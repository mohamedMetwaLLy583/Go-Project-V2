<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderWithPassengersResource;
use App\Models\Order;
use App\Models\OrderPassenger;
use Carbon\Carbon;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\DriverOrderRequest;
use App\Models\Notification;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $status = $request->status;
        $neighborhoodId = $request->neighborhood_id;
        $zone = $request->zone;

        $query = Order::with(['user', 'nationality', 'passengers']);

        // إذا كان المستخدم عميلاً، يرى طلباته فقط
        if ($user->type == \App\Models\User::TYPE_USER) {
            $query->where('user_id', $user->id);
        } 
        // إذا كان السائق، يرى الطلبات المتاحة (pending) أو التي قدم عليها
        else if ($user->type == \App\Models\User::TYPE_DRIVER) {
            $query->where(function($q) use ($user) {
                $q->where('status', 'pending')
                  ->orWhere('selected_driver_id', $user->id)
                  ->orWhereHas('driverRequests', function($sub) use ($user) {
                      $sub->where('driver_id', $user->id);
                  });
            });
        }

        // فلاتر إضافية
        $query->when($status, function ($q) use ($status) {
            $q->where('status', $status);
        });

        // فلترة حسب الحي (Neighborhood)
        $query->when($neighborhoodId, function ($q) use ($neighborhoodId) {
            $neighborhood = \App\Models\Neighborhood::find($neighborhoodId);
            if ($neighborhood) {
                $q->whereHas('passengers', function($sub) use ($neighborhood) {
                    $sub->where('pickup_neighborhood', $neighborhood->name_ar)
                        ->orWhere('pickup_neighborhood', $neighborhood->name_en);
                });
            }
        });

        // فلترة حسب المنطقة (Zone/Region)
        $query->when($zone, function ($q) use ($zone) {
            $neighborhoodNames = \App\Models\Neighborhood::where('direction', $zone)
                ->pluck('name_ar')
                ->toArray();
            
            if (!empty($neighborhoodNames)) {
                $q->whereHas('passengers', function($sub) use ($neighborhoodNames) {
                    $sub->whereIn('pickup_neighborhood', $neighborhoodNames);
                });
            }
        });

        $orders = $query->orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'تم استرجاع الطلبات بنجاح',
            'count' => $orders->count(),
            'data' => OrderWithPassengersResource::collection($orders)
        ]);
    }

    public function store(StoreOrderRequest $request)
    {
        $user = auth('api')->user();
        $setting = Setting::first();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            DB::beginTransaction();

            $price = $request->input('price', 0);

            // إنشاء الطلب بكل الحقول الجديدة
            $order = Order::create([
                'user_id' => $user->id,
                'nationality_id' => $request->nationality_id,
                'price' => $price,
                'salary' => $request->salary,
                'distance_km' => $request->distance_km,
                'app_commission' => $setting->app_commission ?? ($price * 0.1),
                'status' => 'pending',
                'shift_type' => $request->shift_type ?: 'fixed',
                'trip_type' => $request->trip_type ?: 'round_trip',
                'delivery_days' => $request->delivery_days ? json_encode($request->delivery_days) : null,
                'vacation_days' => $request->vacation_days ? json_encode($request->vacation_days) : null,
                'needs_ac' => $request->boolean('needs_ac'),
                'tinted_glass' => $request->boolean('tinted_glass'),
                'car_condition' => $request->car_condition ?: 'standard',
                'is_shared' => $request->boolean('is_shared'),
                'is_urgent' => $request->boolean('is_urgent'),
                'start_date' => $request->start_date,
                'men_count' => $request->men_count ?: 0,
                'women_count' => $request->women_count ?: 0,
                'student_m_count' => $request->student_m_count ?: 0,
                'student_f_count' => $request->student_f_count ?: 0,
                'notes' => $request->notes,
            ]);

            // إنشاء الركاب
            $passengersData = $request->input('passengers');
            foreach ($passengersData as $pData) {
                $order->passengers()->create([
                    'name' => $pData['name'],
                    'type' => $pData['type'] ?? 'male',
                    'pickup_lat' => $pData['pickup_lat'] ?? null,
                    'pickup_lng' => $pData['pickup_lng'] ?? null,
                    'return_lat' => $pData['return_lat'] ?? null,
                    'return_lng' => $pData['return_lng'] ?? null,
                    'pickup_neighborhood' => $pData['pickup_neighborhood'] ?? null,
                    'pickup_location' => $pData['pickup_location'],
                    'pickup_location_type' => $pData['pickup_location_type'] ?? 'home',
                    'return_neighborhood' => $pData['return_neighborhood'] ?? null,
                    'return_location' => $pData['return_location'] ?? null,
                    'return_location_type' => $pData['return_location_type'] ?? 'work',
                    'pickup_time' => isset($pData['pickup_time']) ? Carbon::parse($pData['pickup_time']) : null,
                    'return_time' => isset($pData['return_time']) ? Carbon::parse($pData['return_time']) : null,
                    'driver_arrival_time' => $pData['driver_arrival_time'] ?? null,
                    'work_start_time' => $pData['work_start_time'] ?? null,
                ]);
            }

            DB::commit();
            
            // إشعار لجميع السائقين بوجود طلب جديد
            $drivers = \App\Models\User::where('type', \App\Models\User::TYPE_DRIVER)->get();
            foreach ($drivers as $driver) {
                Notification::create([
                    'user_id' => $driver->id,
                    'title' => 'طلب جديد متاح',
                    'message' => 'يوجد طلب جديد متاح في منطقتك، يمكنك تقدّيم عرضك الآن. رقم الطلب #' . $order->id,
                    'data' => [
                        'order_id' => $order->id,
                        'type' => 'new_order_available'
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء الطلب بنجاح',
                'data' => new OrderWithPassengersResource($order->load(['user', 'nationality', 'passengers']))
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'فشل في إنشاء الطلب',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $order = Order::with(['user', 'nationality', 'passengers'])->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم استرجاع الطلب بنجاح',
            'data' => new OrderWithPassengersResource($order)
        ]);
    }

    public function cancel_order($id)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $order = Order::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود أو غير مصرح لك بإلغائه'
            ], 404);
        }

        if ($order->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'الطلب ملغي بالفعل'
            ], 400);
        }

        // تطبيق سياسة الـ 3 أيام كحد أدنى للإلغاء
        $earliestPickup = $order->passengers()->min('pickup_time');
        if ($earliestPickup && now()->diffInDays($earliestPickup, false) < 3) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن إلغاء الطلب قبل موعده بأقل من 3 أيام حسب سياسة التطبيق'
            ], 400);
        }

        DB::transaction(function () use ($order) {
            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now()
            ]);

            $rejectedApplications = DriverOrderRequest::where('order_id', $order->id)
                ->where('status', 'pending')
                ->get();

            foreach ($rejectedApplications as $application) {
                $application->update([
                    'status' => 'cancelled',
                    'notes'  => 'تم إلغاء الطلب بواسطة العميل'
                ]);

                Notification::create([
                    'user_id' => $application->driver_id,
                    'title' => 'تم إلغاء الطلب بواسطة العميل',
                    'message' => 'تم إلغاء الطلب بواسطة العميل على الطلب رقم #' . $order->id,
                    'data' => [
                        'order_id' => $order->id,
                        'application_id' => $application->id,
                        'type' => 'application_rejected'
                    ]
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'تم إلغاء الطلب وكل عروض السائقين المرتبطة به'
        ]);
    }
}
