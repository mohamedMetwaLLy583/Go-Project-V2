@extends('admin.layouts.app')

@section('title', 'تعديل الصلاحيات')
@section('page-title', 'تعديل دور: ' . $role->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border p-8">
        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-black text-gray-700 mb-2">اسم الدور (الوظيفي)</label>
                <input type="text" name="name" value="{{ $role->name }}" class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-yellow-500 outline-none bg-gray-50" required>
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-black text-gray-700 border-b pb-2">تحديث الصلاحيات</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($availablePermissions as $key => $label)
                    <label class="flex items-center p-4 {{ in_array($key, $role->permissions ?? []) ? 'bg-yellow-50 border-yellow-200' : 'bg-gray-50' }} rounded-xl border cursor-pointer hover:bg-white transition-all group">
                        <input type="checkbox" name="permissions[]" value="{{ $key }}" {{ in_array($key, $role->permissions ?? []) ? 'checked' : '' }} class="w-5 h-5 text-yellow-500 rounded border-gray-300 focus:ring-yellow-500 ml-3">
                        <div>
                            <p class="text-sm font-bold text-gray-800 group-hover:text-yellow-600">{{ $label }}</p>
                            <p class="text-[10px] text-gray-400">السماح بالوصول إلى قسم {{ $label }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end space-x-4 space-x-reverse pt-6 border-t">
                <a href="{{ route('admin.roles.index') }}" class="px-8 py-3 bg-gray-100 text-gray-600 rounded-lg font-bold">إلغاء</a>
                <button type="submit" class="px-8 py-3 bg-yellow-500 text-white rounded-lg font-black shadow-lg hover:shadow-xl transition-all">تحديث الصلاحيات</button>
            </div>
        </form>
    </div>
</div>
@endsection
