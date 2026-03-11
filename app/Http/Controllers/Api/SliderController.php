<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * عرض كل السلايدرات النشطة
     */
    public function index()
    {
        try {
            $sliders = Slider::active()
                ->get()
                ->map(function ($slider) {
                    return [
                        'id' => $slider->id,
                        'image' => $slider->image_url, // Return full URL instead of raw DB path
                        'image_url' => $slider->image_url,
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'تم جلب السلايدرات بنجاح',
                'count' => $sliders->count(),
                'data' => $sliders
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'فشل في جلب السلايدرات: ' . $e->getMessage()
            ], 500);
        }
    }
}
