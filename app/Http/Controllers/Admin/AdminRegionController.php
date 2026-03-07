<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\City;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class AdminRegionController extends Controller
{
    public function index()
    {
        $regions = Region::withCount('neighborhoods')->get();
        return view('admin.regions.index', compact('regions'));
    }

    public function create()
    {
        return view('admin.regions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
        ]);

        Region::create($request->all());

        return redirect()->route('admin.regions.index')->with('success', 'تم إضافة المنطقة بنجاح');
    }

    public function edit($id)
    {
        $region = Region::findOrFail($id);
        return view('admin.regions.edit', compact('region'));
    }

    public function update(Request $request, $id)
    {
        $region = Region::findOrFail($id);
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
        ]);

        $region->update($request->all());

        return redirect()->route('admin.regions.index')->with('success', 'تم تحديث المنطقة بنجاح');
    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        $region->delete();
        return redirect()->route('admin.regions.index')->with('success', 'تم حذف المنطقة');
    }

    // Neighborhoods for a Region
    public function neighborhoods($regionId)
    {
        $region = Region::findOrFail($regionId);
        $neighborhoods = $region->neighborhoods()->with('city')->get();
        $cities = City::all();
        return view('admin.regions.neighborhoods', compact('region', 'neighborhoods', 'cities'));
    }

    public function storeNeighborhood(Request $request, $regionId)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);

        Neighborhood::create([
            'region_id' => $regionId,
            'city_id' => $request->city_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'is_active' => true,
        ]);

        return back()->with('success', 'تم إضافة الحي بنجاح');
    }

    public function deleteNeighborhood($id)
    {
        $neighborhood = Neighborhood::findOrFail($id);
        $neighborhood->delete();
        return back()->with('success', 'تم حذف الحي');
    }
}
