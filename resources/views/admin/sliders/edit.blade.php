@extends('admin.layouts.app')

@section('title', 'تعديل بانر')

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
    <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">صورة البانر الحالية</label>
            @if($slider->image_url)
                <div class="mb-3">
                    <img src="{{ $slider->image_url }}" alt="Slider" class="h-32 rounded-lg border">
                </div>
            @endif
            <input type="file" name="image" class="w-full border rounded-lg p-3 outline-none focus:border-yellow-500 transition-colors" accept="image/*">
            <span class="text-xs text-gray-500 block mt-1">اترك الحقل فارغاً إذا لم ترغب بتغيير الصورة</span>
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">الحالة</label>
            <select name="status" class="w-full border rounded-lg p-3 outline-none focus:border-yellow-500 transition-colors bg-white">
                <option value="active" {{ $slider->status == 'active' ? 'selected' : '' }}>مفعل</option>
                <option value="inactive" {{ $slider->status == 'inactive' ? 'selected' : '' }}>غير مفعل</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg transition-all shadow-md w-full sm:w-auto">
            تحديث البانر
        </button>
    </form>
</div>
@endsection
