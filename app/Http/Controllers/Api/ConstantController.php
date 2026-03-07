<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\City;
use App\Models\Day;
use App\Models\Neighborhood;
use App\Models\Nationality;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\DayResource;
use App\Http\Resources\NeighborhoodResource;

class ConstantController extends Controller
{
    /**
     * Display all countries
     */
    public function countries()
    {
        $countries = Country::where('is_active', true)->get();
        return response()->json([
            'success' => true,
            'data' => CountryResource::collection($countries)
        ]);
    }

    /**
     * Display all cities
     */
    public function cities(Request $request)
    {
        $query = City::where('is_active', true);
        
        // Filter by country if provided
        if ($request->has('country_id')) {
            $query->where('country_id', $request->country_id);
        }
        
        $cities = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => CityResource::collection($cities)
        ]);
    }

    /**
     * Display all days
     */
    public function days()
    {
        $days = Day::where('is_active', true)
            ->orderBy('order')
            ->get();
            
        return response()->json([
            'success' => true,
            'data' => DayResource::collection($days)
        ]);
    }

    /**
     * Display all neighborhoods
     */
    public function neighborhoods(Request $request)
    {
        $query = Neighborhood::where('is_active', true);
        
        // Filter by city if provided
        if ($request->has('city_id')) {
            $query->where('city_id', $request->city_id);
        }
        
        $neighborhoods = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => NeighborhoodResource::collection($neighborhoods)
        ]);
    }

    public function nationalities()
    {
        $nationalities = Nationality::all();
        return response()->json([
            'success' => true,
            'data' => $nationalities
        ]);
    }

    public function regions()
    {
        $regions = Region::with(['neighborhoods' => function($q) {
            $q->where('is_active', true);
        }])->where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'data' => $regions
        ]);
    }
}