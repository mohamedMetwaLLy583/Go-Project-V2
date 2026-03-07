@extends('admin.layouts.app')

@section('title', 'تعديل بيانات موظف')
@section('page-title', 'تعديل موظف: ' . $member->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border p-8">
        <form action="{{ route('admin.staff.update', $member->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">اسم الموظف</label>
                <input type="text" name="name" value="{{ $member->name }}" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ $member->email }}" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">كلمة المرور (اتركها فارغة إذا لم تود تغييرها)</label>
                <input type="password" name="password" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">تعديل الدور</label>
                <select name="role_id" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none bg-gray-50">
                    <option value="">مدير عام (Super Admin)</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $member->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end space-x-4 space-x-reverse pt-4">
                <a href="{{ route('admin.staff.index') }}" class="px-6 py-2 bg-gray-100 text-gray-600 rounded-lg font-bold">إلغاء</a>
                <button type="submit" class="px-6 py-2 bg-yellow-500 text-white rounded-lg font-bold hover:bg-yellow-600 shadow-md">تحديث البيانات</button>
            </div>
        </form>
    </div>
</div>
@endsection
