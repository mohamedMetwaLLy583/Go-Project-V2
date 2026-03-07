@extends('admin.layouts.app')

@section('title', 'إضافة جنسية')
@section('page-title', 'إضافة جنسية جديدة')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border p-8">
        <form action="{{ route('admin.nationalities.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">اسم الجنسية (بالعربية)</label>
                <input type="text" name="name_ar" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none" placeholder="مثال: سعودي" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">اسم الجنسية (بالإنجليزية)</label>
                <input type="text" name="name_en" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none" placeholder="Example: Saudi" required>
            </div>
            <div class="flex justify-end space-x-4 space-x-reverse pt-4">
                <a href="{{ route('admin.nationalities.index') }}" class="px-6 py-2 bg-gray-100 text-gray-600 rounded-lg font-bold">إلغاء</a>
                <button type="submit" class="px-6 py-2 bg-yellow-500 text-white rounded-lg font-bold hover:bg-yellow-600 shadow-md">حفظ الجنسية</button>
            </div>
        </form>
    </div>
</div>
@endsection
