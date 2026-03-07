<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDriverController extends Controller
{
    /**
     * List all drivers
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = User::where('type', 2)->with('carImages')->latest();

        if ($request->has('status')) {
            $query->where('status', $status);
        }

        $drivers = $query->paginate(20);

        return view('admin.drivers.index', compact('drivers', 'status'));
    }

    /**
     * Show driver details
     */
    public function show($id)
    {
        $driver = User::where('type', 2)->with(['carImages', 'driverAvailability.neighborhood', 'driverAvailability.day'])->findOrFail($id);

        return view('admin.drivers.show', compact('driver'));
    }

    /**
     * Update status (Approve/Reject)
     */
    public function updateStatus(Request $request, $id)
    {
        $driver = User::where('type', 2)->findOrFail($id);
        
        $driver->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'تم تحديث حالة السائق بنجاح');
    }
}
