<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebRideRequest;
use Illuminate\Http\Request;

class AdminWebRideRequestController extends Controller
{
    /**
     * List all ride requests
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = WebRideRequest::latest();

        if ($status) {
            $query->where('status', $status);
        }

        $requests = $query->paginate(20);

        return view('admin.web_ride_requests.index', compact('requests', 'status'));
    }

    /**
     * Update request status
     */
    public function updateStatus(Request $request, $id)
    {
        $rideReq = WebRideRequest::findOrFail($id);
        
        $rideReq->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    /**
     * Delete the request
     */
    public function destroy($id)
    {
        $rideReq = WebRideRequest::findOrFail($id);
        $rideReq->delete();

        return back()->with('success', 'تم حذف الطلب بنجاح');
    }
}
