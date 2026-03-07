@extends('admin.layouts.app')

@section('title', 'إضافة موظف')
@section('page-title', 'إضافة موظف إدارة جديد')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border p-8">
        <form action="{{ route('admin.staff.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">اسم الموظف</label>
                <input type="text" name="name" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني (الدخول)</label>
                <input type="email" name="email" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">كلمة المرور</label>
                <input type="password" name="password" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">تحديد الدور (الصلاحيات)</label>
                <select name="role_id" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none bg-gray-50">
                    <option value="">مدير عام (Super Admin - كل الصلاحيات)</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end space-x-4 space-x-reverse pt-4">
                <a href="{{ route('admin.staff.index') }}" class="px-6 py-2 bg-gray-100 text-gray-600 rounded-lg font-bold">إلغاء</a>
                <button type="submit" class="px-6 py-2 bg-yellow-500 text-white rounded-lg font-bold hover:bg-yellow-600 shadow-md">حفظ الموظف</button>
            </div>
        </form>
    </div>
</div>
@endsection
