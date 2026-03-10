<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DriverOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class DriverOrderRequestController extends Controller
{
    /**
     * السواق يقدم على أوردر
     */
    public function apply(Request $request, Order $order)
    {
        $request->validate([
            'proposed_price' => 'nullable|numeric|min:1',
            'notes' => 'nullable|string'
        ]);

        $driver = auth('api')->user();

        // منع التقديم مرتين
        if ($order->driverRequests()->where('driver_id', $driver->id)->exists()) {
            return response()->json([
                'message' => 'لقد قمت بالتقديم مسبقًا على هذا الطلب'
            ], 422);
        }

        // التأكد من أن حساب السائق مفعل (تمت مراجعته من لوحة التحكم)
        if ($driver->status == 0) {
            return response()->json([
                'message' => 'عذراً، حسابك قيد المراجعة ولا يمكنك التقديم على الطلبات حالياً'
            ], 403);
        }

        // التأكد من أن السائق يمتلك نقاط/رصيد كافي يغطي عمولة التطبيق للطلب
        if ($driver->coins < $order->app_commission) {
            return response()->json([
                'message' => 'عذراً، رصيد النقاط الخاص بك غير كافٍ للتقديم على هذا الطلب'
            ], 403);
        }

        $application = DriverOrderRequest::create([
            'order_id' => $order->id,
            'driver_id' => $driver->id,
            'proposed_price' => $request->proposed_price,
            'notes' => $request->notes,
        ]);

        // إشعار للعميل
        Notification::create([
            'user_id' => $order->user_id,
            'title' => 'طلب جديد على الأوردر',
            'message' => 'يوجد سائق قدم عرضًا على طلبك',
            'data' => [
                'order_id' => $order->id,
                'application_id' => $application->id,
                'driver_id' => $driver->id,
                'type' => 'new_application'
            ]
        ]);

        return response()->json([
            'message' => 'تم التقديم بنجاح',
            'data' => $application
        ]);
    }

    /**
     * العميل يشوف كل التقديمات
     */
    public function applications(Order $order)
    {
        // نتأكد أن صاحب الأوردر هو اللي بيطلب البيانات
        if ($order->user_id !== auth('api')->id()) {
            return response()->json([
                'error' => 'غير مصرح لك'
            ], 403);
        }

        $applications = $order->driverRequests()
            ->with('driver')
            ->orderBy('proposed_price', 'asc') // الأقل سعر أولاً
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'تم جلب التقديمات بنجاح',
            'count' => $applications->count(),
            'data' => $applications
        ], 200);
    }

    /**
     * قبول سواق
     */
    public function accept(DriverOrderRequest $application)
    {
        $order = $application->order;

        if ($order->user_id !== auth('api')->id()) {
            return response()->json([
                'error' => 'غير مصرح لك'
            ], 403);
        }

        DB::transaction(function () use ($application, $order) {

            // قبول السواق المختار
            $application->update([
                'status' => 'accepted'
            ]);

            // إشعار للسواق المقبول
            Notification::create([
                'user_id' => $application->driver_id,
                'title' => 'تم قبول عرضك',
                'message' => 'تم قبول عرضك على الطلب رقم #' . $order->id,
                'data' => [
                    'order_id' => $order->id,
                    'application_id' => $application->id,
                    'type' => 'application_accepted'
                ]
            ]);

            // باقي السواقين اللي هيترفضوا
            $rejectedApplications = DriverOrderRequest::where('order_id', $order->id)
                ->where('id', '!=', $application->id)
                ->get();

            foreach ($rejectedApplications as $rejected) {
                // تحديث الحالة
                $rejected->update(['status' => 'rejected']);

                // إشعار لهم
                Notification::create([
                    'user_id' => $rejected->driver_id,
                    'title' => 'تم رفض عرضك',
                    'message' => 'تم رفض عرضك على الطلب رقم #' . $order->id,
                    'data' => [
                        'order_id' => $order->id,
                        'application_id' => $rejected->id,
                        'type' => 'application_rejected'
                    ]
                ]);
            }

            // تحديث حالة الأوردر وحفظ السائق المختار
            $order->update([
                'status' => 'pending', // يظل بانتظار التنفيذ ولكن مع سائق مختار
                'selected_driver_id' => $application->driver_id
            ]);
        });

        return response()->json([
            'message' => 'تم قبول السواق بنجاح'
        ]);
    }

    /**
     * رفض سواق
     */
    public function reject(DriverOrderRequest $application)
    {
        $order = $application->order;

        if ($order->user_id !== auth('api')->id()) {
            return response()->json([
                'error' => 'غير مصرح لك'
            ], 403);
        }

        $application->update([
            'status' => 'rejected'
        ]);

        Notification::create([
            'user_id' => $application->driver_id,
            'title' => 'تم رفض عرضك',
            'message' => 'تم رفض عرضك على الطلب رقم #' . $order->id,
            'data' => [
                'order_id' => $order->id,
                'application_id' => $application->id,
                'type' => 'application_rejected'
            ]
        ]);

        return response()->json([
            'message' => 'تم رفض السواق'
        ]);
    }
}
