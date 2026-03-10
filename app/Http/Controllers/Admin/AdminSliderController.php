<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminSliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'required|in:active,inactive'
        ]);

        $slider = new Slider();
        $slider->status = $request->status;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/sliders'), $imageName);
            $slider->image = 'uploads/sliders/' . $imageName;
        }

        $slider->save();

        return redirect()->route('admin.sliders.index')->with('success', 'تم إضافة البانر بنجاح');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'required|in:active,inactive'
        ]);

        $slider->status = $request->status;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($slider->image && File::exists(public_path($slider->image))) {
                File::delete(public_path($slider->image));
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/sliders'), $imageName);
            $slider->image = 'uploads/sliders/' . $imageName;
        }

        $slider->save();

        return redirect()->route('admin.sliders.index')->with('success', 'تم تحديث البانر بنجاح');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        if ($slider->image && File::exists(public_path($slider->image))) {
            File::delete(public_path($slider->image));
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'تم حذف البانر بنجاح');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $slider = Slider::findOrFail($id);
        $slider->status = $request->status;
        $slider->save();

        return redirect()->route('admin.sliders.index')->with('success', 'تم تحديث حالة البانر بنجاح');
    }
}
