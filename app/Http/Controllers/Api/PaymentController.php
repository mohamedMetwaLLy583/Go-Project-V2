<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\GooglePlayService;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized - User not found'
            ], 401);
        }

        $payments = Payment::where('user_id', $user->id)->orderBy('date', 'desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'تم جلب عمليات الشراء بنجاح',
            'data' => $payments
        ], 200);
    }

    public function store(Request $request, GooglePlayService $google)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized - User not found'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|string',
            'purchase_id' => 'required|string',
            'purchase_token' => 'required|string',
            'package_id' => 'required|exists:packages,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // منع استخدام نفس التوكن مرتين
        if (Payment::where('purchase_token', $request->purchase_token)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'عملية شراء مكررة'
            ], 409);
        }

        try {
            $packageName = config('services.google.package') ?? env('GOOGLE_PLAY_PACKAGE');

            // 1️⃣ التحقق من Google
            $purchase = $google->verifyProduct(
                $packageName,
                $request->product_id,
                $request->purchase_token
            );

            // 2️⃣ التأكد إن الدفع تم
            if ($purchase->getPurchaseState() !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'الدفع غير مكتمل'
                ], 400);
            }

            DB::transaction(function () use ($request, $purchase, $google, $packageName) {

                // 3️⃣ استهلاك المنتج أولاً (Consume)
                $google->consumeProduct(
                    $packageName,
                    $request->product_id,
                    $request->purchase_token
                );

                // جلب بيانات الباقة بناءً على product_id
                $package = Package::findOrFail($request->package_id);
                $startDate = now();
                $endDate = now()->addMonths($package->duration); // Assuming duration is in months


                // 4️⃣ حفظ الدفع
                Payment::create([
                    'user_id' => auth('api')->user()->id,
                    'product_id' => $request->product_id,
                    'purchase_id' => $request->purchase_id,
                    'purchase_token' => $request->purchase_token,
                    'coins' => $package->coins,
                    'price' => $package->price,
                    'title' => 'شحن رصيد',
                    'status' => 'paid',
                    'date' => now(),
                    'package_id' => $package->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);

                // 5️⃣ شحن الكوينز
                User::where('id', auth('api')->user()->id)->increment('coins', $package->coins);
            });

            return response()->json([
                'success' => true,
                'message' => 'تم التحقق من الدفع وشحن الرصيد بنجاح'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل التحقق من Google',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
