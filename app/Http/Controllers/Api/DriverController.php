<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\DriverResource;

class DriverController extends Controller
{

    public function index(Request $request)
    {
        try {

            $neighborhoodId = $request->neighborhood_id;
            $zone = $request->zone;
            $acceptSmoking = $request->accept_smoking;
            $acceptOthers = $request->accept_others;
            $carType = $request->car_type;

            $drivers = User::with(['carImages', 'driverAvailability.neighborhood'])
                ->where('type', 2)
                ->when($neighborhoodId, function ($query) use ($neighborhoodId) {
                    $query->whereHas('driverAvailability', function ($q) use ($neighborhoodId) {
                        $q->ofNeighborhood($neighborhoodId)->active();
                    });
                })
                ->when($zone, function ($query) use ($zone) {
                    $query->whereHas('driverAvailability.neighborhood', function ($q) use ($zone) {
                        $q->where('zone', $zone);
                    });
                })
                ->when($request->has('accept_smoking'), function ($query) use ($acceptSmoking) {
                    $query->where('accept_smoking', $acceptSmoking);
                })
                ->when($request->has('accept_others'), function ($query) use ($acceptOthers) {
                    $query->where('accept_others', $acceptOthers);
                })
                ->when($carType, function ($query) use ($carType) {
                    $query->where('car_type', $carType);
                })
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'تم جلب السائقين بنجاح',
                'count' => $drivers->count(),
                'data' => DriverResource::collection($drivers)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'فشل في جلب السائقين: ' . $e->getMessage()
            ], 500);
        }
    }
}
