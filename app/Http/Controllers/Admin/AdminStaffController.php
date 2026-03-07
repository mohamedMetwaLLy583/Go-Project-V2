<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminStaffController extends Controller
{
    public function index()
    {
        $staff = User::where('type', 1)->with('role')->get();
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.staff.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 1, // Admin
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'تم إضافة الموظف بنجاح');
    }

    public function edit($id)
    {
        $member = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.staff.edit', compact('member', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $member = User::findOrFail($id);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $member->update($data);

        return redirect()->route('admin.staff.index')->with('success', 'تم تحديث بيانات الموظف');
    }

    public function destroy($id)
    {
        $member = User::findOrFail($id);
        if ($member->id === auth()->id()) {
            return back()->with('error', 'لا يمكنك حذف نفسك!');
        }
        $member->delete();
        return redirect()->route('admin.staff.index')->with('success', 'تم حذف الموظف');
    }
}
