<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Validator;

class SupportTicketController extends Controller
{
    /**
     * List user's support tickets.
     */
    public function index()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tickets = SupportTicket::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tickets
        ]);
    }

    /**
     * Submit a new support ticket.
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'nullable|in:low,medium,high',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $ticket = SupportTicket::create([
            'user_id' => $user->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority ?? 'medium',
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم استلام طلبك بنجاح، سيتم التواصل معك قريباً',
            'data' => $ticket
        ]);
    }

    /**
     * Get details of a single ticket.
     */
    public function show($id)
    {
        $user = auth('api')->user();
        $ticket = SupportTicket::where('user_id', $user->id)->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $ticket
        ]);
    }
}
