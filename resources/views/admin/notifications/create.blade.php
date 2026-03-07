@extends('admin.layouts.app')

@section('title', 'إرسال إشعار')
@section('page-title', 'إرسال إشعار جديد للسماعات')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border p-8">
        <form action="{{ route('admin.notifications.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">المرسل إليه</label>
                <select name="user_id" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none bg-gray-50" required>
                    <option value="all">كل المستخدمين والسائقين</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->phone }} - {{ $user->getTypeTextAttribute() }})</option>
                    @endforeach
                </select>
                <p class="text-[10px] text-gray-400 mt-1">سيتم إرسال إشعار فوري (Push Notification) لهذا المستخدم</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">عنوان الإشعار</label>
                <input type="text" name="title" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none" placeholder="مثال: عرض جديد متوفر" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">محتوى الإشعار</label>
                <textarea name="message" rows="4" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none" placeholder="اكتب نص الرسالة هنا..." required></textarea>
            </div>

            <div class="flex justify-end space-x-4 space-x-reverse pt-4 border-t">
                <a href="{{ route('admin.notifications.index') }}" class="px-8 py-3 bg-gray-100 text-gray-600 rounded-lg font-bold">إلغاء</a>
                <button type="submit" class="px-8 py-3 bg-yellow-500 text-white rounded-lg font-black shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">إرسال الآن ✉️</button>
            </div>
        </form>
    </div>
</div>
@endsection
