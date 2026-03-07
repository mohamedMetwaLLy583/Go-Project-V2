@extends('admin.layouts.app')

@section('title', 'مركز الإشعارات')

@section('page-title')
<div class="flex justify-between items-center w-full">
    <span>مركز الإشعارات</span>
    <div class="flex space-x-3 space-x-reverse">
        <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST">
            @csrf
            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition-all border">
                تحديد الكل كمقروء
            </button>
        </form>
        <a href="{{ route('admin.notifications.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg text-sm font-bold transition-all shadow-md">
            + إرسال إشعار جديد
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-4">
    @forelse($notifications as $notification)
    <div class="bg-white rounded-xl shadow-sm border p-6 flex justify-between items-center {{ !$notification->is_read ? 'border-r-4 border-yellow-500 bg-yellow-50/20' : '' }}">
        <div class="flex items-start space-x-4 space-x-reverse">
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-xl">
                {{ !$notification->is_read ? '🔔' : '🔕' }}
            </div>
            <div>
                <h4 class="font-bold text-gray-800">{{ $notification->title }}</h4>
                <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                <div class="flex items-center space-x-4 space-x-reverse mt-2">
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $notification->created_at->diffForHumans() }}</span>
                    <span class="text-[10px] text-blue-500 font-bold">إلى: {{ $notification->user->name ?? 'الكل' }}</span>
                </div>
            </div>
        </div>
        <div>
            <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl shadow-sm border p-12 text-center text-gray-400 italic">
        لا توجد إشعارات حالياً
    </div>
    @endforelse

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
