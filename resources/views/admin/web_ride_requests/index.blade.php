@extends('admin.layouts.app')

@section('title', 'طلبات المشاوير (من الموقع)')
@section('page-title', 'طلبات المشاوير (من الموقع)')

@section('content')
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="p-6 border-b bg-gray-50 flex space-x-4 space-x-reverse">
        <a href="{{ route('admin.web-ride-requests.index') }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ !request('status') ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }}">الكل</a>
        <a href="{{ route('admin.web-ride-requests.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }}">طلبات جديدة</a>
        <a href="{{ route('admin.web-ride-requests.index', ['status' => 'completed']) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == 'completed' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">منجزة</a>
        <a href="{{ route('admin.web-ride-requests.index', ['status' => 'cancelled']) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == 'cancelled' ? 'bg-gray-500 text-white' : 'bg-gray-200 text-gray-700' }}">ملغاة</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse whitespace-nowrap">
            <thead class="bg-gray-50 text-gray-500 text-sm">
                <tr>
                    <th class="px-6 py-4 border-b">العميل</th>
                    <th class="px-6 py-4 border-b">رقم الجوال</th>
                    <th class="px-6 py-4 border-b">نقطة الانطلاق (من)</th>
                    <th class="px-6 py-4 border-b">الوجهة (إلى)</th>
                    <th class="px-6 py-4 border-b">الوقت</th>
                    <th class="px-6 py-4 border-b">الحالة</th>
                    <th class="px-6 py-4 border-b">حذف</th>
                </tr>
            </thead>
            <tbody class="divide-y text-sm">
                @forelse($requests as $req)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-bold">{{ $req->name }}</td>
                    <td class="px-6 py-4" dir="ltr">{{ $req->phone }}</td>
                    <td class="px-6 py-4 text-blue-600 truncate max-w-[150px]"><span title="{{ $req->pickup_location }}">{{ $req->pickup_location }}</span></td>
                    <td class="px-6 py-4 text-green-600 truncate max-w-[150px]"><span title="{{ $req->dropoff_location }}">{{ $req->dropoff_location }}</span></td>
                    <td class="px-6 py-4 text-gray-500">{{ $req->created_at->diffForHumans() }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.web-ride-requests.update-status', $req->id) }}" method="POST" class="flex items-center space-x-2 space-x-reverse">
                            @csrf
                            <select name="status" class="border-gray-300 rounded text-sm py-1">
                                <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>جديد</option>
                                <option value="completed" {{ $req->status == 'completed' ? 'selected' : '' }}>مُنجز</option>
                                <option value="cancelled" {{ $req->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                            </select>
                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-bold hover:bg-blue-600">تحديث</button>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.web-ride-requests.destroy', $req->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">لا يوجد طلبات حالياً</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-6 border-t font-semibold">
        {{ $requests->links() }}
    </div>
</div>
@endsection
