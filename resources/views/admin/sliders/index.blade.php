@extends('admin.layouts.app')

@section('title', 'البانرات (Sliders)')

@section('page-title')
<div class="flex justify-between items-center w-full">
    <span>البانرات (Sliders)</span>
    <a href="{{ route('admin.sliders.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg text-sm font-bold transition-all shadow-md">
        + إضافة بانر جديد
    </a>
</div>
@endsection

@section('content')
<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($sliders as $slider)
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden flex flex-col">
            <div class="relative pb-[50%] bg-gray-100">
                <img src="{{ $slider->image_url }}" alt="Slider" class="absolute inset-0 w-full h-full object-cover">
            </div>
            <div class="p-4 flex flex-col flex-1 justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm font-bold {{ $slider->status === 'active' ? 'text-green-500' : 'text-gray-400' }}">
                        {{ $slider->status === 'active' ? 'مفعل' : 'غير مفعل' }}
                    </span>
                    <span class="text-[10px] text-gray-400 font-bold tracking-wider">{{ $slider->created_at->diffForHumans() }}</span>
                </div>
                
                <div class="flex justify-between items-center pt-3 border-t">
                    <form action="{{ route('admin.sliders.update-status', $slider->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="{{ $slider->status === 'active' ? 'inactive' : 'active' }}">
                        <button type="submit" class="{{ $slider->status === 'active' ? 'text-orange-500' : 'text-green-500' }} hover:text-opacity-80 transition-colors font-bold text-sm">
                            {{ $slider->status === 'active' ? 'إيقاف' : 'تفعيل' }}
                        </button>
                    </form>

                    <div class="flex space-x-3 space-x-reverse">
                        <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="text-blue-500 hover:text-blue-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-xl shadow-sm border p-12 text-center text-gray-400 italic">
            لا توجد بانرات حالياً
        </div>
        @endforelse
    </div>
</div>
@endsection
