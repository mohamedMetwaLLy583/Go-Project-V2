<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    /**
     * List all support tickets
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = SupportTicket::with('user')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $tickets = $query->paginate(20);

        return view('admin.tickets.index', compact('tickets', 'status'));
    }

    /**
     * Show ticket details
     */
    public function show($id)
    {
        $ticket = SupportTicket::with('user')->findOrFail($id);

        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Update ticket status
     */
    public function updateStatus(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        
        $ticket->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'تم تحديث حالة التذكرة بنجاح');
    }
}
