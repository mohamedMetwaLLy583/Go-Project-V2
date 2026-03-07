<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    /**
     * Submit a rating for an order.
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'to_id' => 'required|exists:users,id',
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Check if user is part of the order
        $order = Order::findOrFail($request->order_id);
        if ($order->user_id != $user->id && $order->selected_driver_id != $user->id) {
            return response()->json(['error' => 'You are not authorized to rate this order'], 403);
        }

        // Prevent multiple ratings for the same order from same person to same person
        $exists = Rating::where('order_id', $request->order_id)
            ->where('from_id', $user->id)
            ->where('to_id', $request->to_id)
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'You have already rated this user for this order'], 400);
        }

        $rating = Rating::create([
            'order_id' => $request->order_id,
            'from_id' => $user->id,
            'to_id' => $request->to_id,
            'stars' => $request->stars,
            'comment' => $request->comment,
        ]);

        // Update average rating for the "to" user
        $this->updateUserAverageRating($request->to_id);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال التقييم بنجاح',
            'data' => $rating
        ]);
    }

    /**
     * Get ratings for a specific user (e.g. driver).
     */
    public function userRatings($userId)
    {
        $ratings = Rating::where('to_id', $userId)
            ->with('from:id,name,profile_picture')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $ratings
        ]);
    }

    /**
     * Helper to update user average rating.
     */
    private function updateUserAverageRating($userId)
    {
        $average = Rating::where('to_id', $userId)->avg('stars');
        User::where('id', $userId)->update(['average_rating' => $average]);
    }
}
