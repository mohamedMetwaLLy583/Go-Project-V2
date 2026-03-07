<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Nationality;
use App\Models\OrderPassenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    /**
     * List all orders
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Order::with(['user', 'passengers'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(20);

        return view('admin.orders.index', compact('orders', 'status'));
    }

    /**
     * Show order details
     */
    public function show($id)
    {
        $order = Order::with(['user', 'passengers', 'driverRequests.driver', 'selectedDriver'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    /**
     * Show create order form
     */
    public function create()
    {
        $users = User::where('type', 3)->get(); // Regular users
        $nationalities = Nationality::all();
        
        return view('admin.orders.create', compact('users', 'nationalities'));
    }

    /**
     * Store new order
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nationality_id' => 'required|exists:nationalities,id',
            'price' => 'nullable|numeric|min:0',
            'salary' => 'nullable|numeric|min:0',
            'distance_km' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'shift_type' => 'nullable|in:fixed,variable',
            'trip_type' => 'nullable|in:round_trip,go_only,return_only',
            'car_condition' => 'nullable|in:standard,new',
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string',
            'passengers.*.type' => 'required|in:male,female,child,elderly',
            'passengers.*.pickup_location' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $price = $request->price ?: 0;
            
            $order = Order::create([
                'user_id' => $request->user_id,
                'nationality_id' => $request->nationality_id,
                'price' => $price,
                'salary' => $request->salary,
                'distance_km' => $request->distance_km,
                'app_commission' => $price * 0.1, 
                'status' => 'pending',
                'shift_type' => $request->shift_type ?: 'fixed',
                'trip_type' => $request->trip_type ?: 'round_trip',
                'delivery_days' => $request->delivery_days ? json_encode($request->delivery_days) : null,
                'vacation_days' => $request->vacation_days ? json_encode($request->vacation_days) : null,
                'needs_ac' => $request->has('needs_ac'),
                'tinted_glass' => $request->has('tinted_glass'),
                'car_condition' => $request->car_condition ?: 'standard',
                'is_shared' => $request->has('is_shared'),
                'is_urgent' => $request->has('is_urgent'),
                'start_date' => $request->start_date,
                'men_count' => $request->men_count ?: 0,
                'women_count' => $request->women_count ?: 0,
                'student_m_count' => $request->student_m_count ?: 0,
                'student_f_count' => $request->student_f_count ?: 0,
                'notes' => $request->notes,
            ]);

            foreach ($request->passengers as $passengerData) {
                $order->passengers()->create([
                    'name' => $passengerData['name'],
                    'type' => $passengerData['type'],
                    'pickup_location_type' => $passengerData['pickup_location_type'] ?? 'home',
                    'pickup_neighborhood' => $passengerData['pickup_neighborhood'] ?? null,
                    'pickup_location' => $passengerData['pickup_location'],
                    'return_location_type' => $passengerData['return_location_type'] ?? 'work',
                    'return_neighborhood' => $passengerData['return_neighborhood'] ?? null,
                    'return_location' => $passengerData['return_location'] ?? null,
                    'driver_arrival_time' => $passengerData['driver_arrival_time'] ?? null,
                    'work_start_time' => $passengerData['work_start_time'] ?? null,
                    'return_time' => $passengerData['return_time'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.orders.index')->with('success', 'تم إضافة الطلب بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ أثناء إضافة الطلب: ' . $e->getMessage()]);
        }
    }
}
