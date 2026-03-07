<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nationality;
use Illuminate\Http\Request;

class AdminNationalityController extends Controller
{
    public function index()
    {
        $nationalities = Nationality::all();
        return view('admin.nationalities.index', compact('nationalities'));
    }

    public function create()
    {
        return view('admin.nationalities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        Nationality::create($request->all());

        return redirect()->route('admin.nationalities.index')->with('success', 'تم إضافة الجنسية بنجاح');
    }

    public function edit($id)
    {
        $nationality = Nationality::findOrFail($id);
        return view('admin.nationalities.edit', compact('nationality'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $nationality = Nationality::findOrFail($id);
        $nationality->update($request->all());

        return redirect()->route('admin.nationalities.index')->with('success', 'تم تحديث الجنسية بنجاح');
    }

    public function destroy($id)
    {
        $nationality = Nationality::findOrFail($id);
        
        if ($nationality->users()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف هذه الجنسية لوجود مستخدمين مرتبطين بها');
        }

        $nationality->delete();
        return redirect()->route('admin.nationalities.index')->with('success', 'تم حذف الجنسية بنجاح');
    }
}
