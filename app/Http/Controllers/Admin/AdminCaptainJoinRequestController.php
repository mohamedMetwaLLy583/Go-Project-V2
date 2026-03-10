<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaptainJoinRequest;
use Illuminate\Http\Request;

class AdminCaptainJoinRequestController extends Controller
{
    /**
     * List all join requests
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = CaptainJoinRequest::latest();

        if ($status) {
            $query->where('status', $status);
        }

        $requests = $query->paginate(20);

        return view('admin.captain_requests.index', compact('requests', 'status'));
    }

    /**
     * Update request status
     */
    public function updateStatus(Request $request, $id)
    {
        $joinReq = CaptainJoinRequest::findOrFail($id);
        
        $joinReq->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'تم تحديث الحالة بنجاح');
    }

    /**
     * Delete the request
     */
    public function destroy($id)
    {
        $joinReq = CaptainJoinRequest::findOrFail($id);
        $joinReq->delete();

        return back()->with('success', 'تم حذف الطلب بنجاح');
    }
}
