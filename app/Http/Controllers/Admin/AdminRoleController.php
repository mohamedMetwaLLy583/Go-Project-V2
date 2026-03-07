<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminRoleController extends Controller
{
    public $permissions = [
        'manage_drivers' => 'إدارة السوارق',
        'manage_orders' => 'إدارة الطلبات',
        'manage_users' => 'إدارة المستخدمين',
        'manage_tickets' => 'إدارة التذاكر',
        'manage_nationalities' => 'إدارة الجنسيات',
        'manage_notifications' => 'إدارة الإشعارات',
        'manage_roles' => 'إدارة الأدوار والصلاحيات',
        'view_financials' => 'عرض البيانات المالية',
    ];

    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create', ['availablePermissions' => $this->permissions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array'
        ]);

        Role::create([
            'name' => $request->name,
            'permissions' => $request->permissions
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'تم إنشاء الدور بنجاح');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', [
            'role' => $role,
            'availablePermissions' => $this->permissions
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array'
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
            'permissions' => $request->permissions
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'تم تحديث الدور بنجاح');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if ($role->users()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف الدور لوجود مستخدمين مرتبطين به');
        }
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'تم حذف الدور');
    }
}
