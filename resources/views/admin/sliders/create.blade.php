@extends('admin.layouts.app')

@section('title', 'إضافة بانر جديد')

@section('page-title')
<div class="flex items-center space-x-4 space-x-reverse">
    <a href="{{ route('admin.sliders.index') }}" class="text-gray-400 hover:text-gray-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </a>
    <span>عُد للبانرات</span>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border p-6">
    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">صورة البانر</label>
            <input type="file" name="image" required class="w-full border rounded-lg p-3 outline-none focus:border-yellow-500 transition-colors" accept="image/*">
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">الحالة</label>
            <select name="status" class="w-full border rounded-lg p-3 outline-none focus:border-yellow-500 transition-colors bg-white">
                <option value="active">مفعل</option>
                <option value="inactive">غير مفعل</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-lg transition-all shadow-md w-full sm:w-auto">
            إضافة البانر
        </button>
    </form>
</div>
@endsection
