<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    /**
     * Get current wallet balance and recent transactions.
     */
    public function index()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $transactions = WalletTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'balance' => $user->wallet_balance ?? 0,
            'coins' => $user->coins ?? 0,
            'transactions' => $transactions
        ]);
    }

    /**
     * Mock deposit to wallet.
     */
    public function deposit(Request $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            DB::beginTransaction();

            $transaction = WalletTransaction::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'deposit',
                'description' => $request->description ?? 'شحن محفظة',
                'status' => 'completed',
            ]);

            $user->increment('wallet_balance', $request->amount);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم شحن المحفظة بنجاح',
                'balance' => $user->wallet_balance,
                'transaction' => $transaction
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Deposit failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * In-App Purchase Recharge (Google/Apple)
     */
    public function iapCharge(Request $request)
    {
        $user = auth('api')->user();
        if (!$user) return response()->json(['error' => 'Unauthorized'], 401);

        $request->validate([
            'purchase_token' => 'required|string',
            'product_id' => 'required|string',
            'platform' => 'required|in:android,ios',
            'amount' => 'required|numeric|min:0.01',
        ]);

        try {
            DB::beginTransaction();

            // Check if this purchase token was already used
            $exists = WalletTransaction::where('reference_id', $request->purchase_token)->exists();
            if ($exists) {
                return response()->json(['success' => false, 'message' => 'هذه العملية تم تنفيذها مسبقاً'], 422);
            }

            // NOTE: In production, you should verify the purchase_token with Google/Apple services here.
            // Example for Google: use Google_Service_AndroidPublisher
            // Example for Apple: verify with https://buy.itunes.apple.com/verifyReceipt

            $transaction = WalletTransaction::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'deposit',
                'description' => 'شحن عبر المتجر (' . ($request->platform == 'android' ? 'Google Play' : 'App Store') . ')',
                'status' => 'completed',
                'reference_id' => $request->purchase_token, // Save token as reference to prevent reuse
                'data' => [
                    'product_id' => $request->product_id,
                    'platform' => $request->platform
                ]
            ]);

            $user->increment('wallet_balance', $request->amount);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم شحن المحفظة بنجاح عبر المتجر',
                'balance' => $user->wallet_balance,
                'transaction' => $transaction
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('IAP Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'فشل في عملية الشحن'], 500);
        }
    }
}
