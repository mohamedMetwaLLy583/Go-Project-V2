<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * عرض كل الباقات النشطة
     */
    public function index()
    {
        try {
            $packages = Package::active()
                ->sorted()
                ->get()
                ->map(function ($package) {
                    return [
                        'id' => $package->id,
                        // 'name' => $package->name,
                        'price' => $package->price,
                        'coins' => $package->coins,
                        'duration' => $package->duration,
                        'duration_unit' => $package->duration_unit,
                        'features' => $package->features,
                        'sort_order' => $package->sort_order,
                        'is_popular' => $package->is_popular,
                        'investment_amount' => $package->investment_amount,
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'تم جلب الباقات بنجاح',
                'count' => $packages->count(),
                'data' => $packages
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'فشل في جلب الباقات: ' . $e->getMessage()
            ], 500);
        }
    }
}
