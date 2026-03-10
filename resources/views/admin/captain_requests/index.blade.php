@extends('admin.layouts.app')

@section('title', 'طلبات انضمام الكباتن')
@section('page-title', 'طلبات انضمام الكباتن')

@section('content')
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="p-6 border-b bg-gray-50 flex space-x-4 space-x-reverse">
        <a href="{{ route('admin.captain-requests.index') }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ !request('status') ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }}">الكل</a>
        <a href="{{ route('admin.captain-requests.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }}">طلبات جديدة</a>
        <a href="{{ route('admin.captain-requests.index', ['status' => 'contacted']) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == 'contacted' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">تم التواصل</a>
        <a href="{{ route('admin.captain-requests.index', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == 'rejected' ? 'bg-gray-500 text-white' : 'bg-gray-200 text-gray-700' }}">مرفوضة</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse whitespace-nowrap">
            <thead class="bg-gray-50 text-gray-500 text-sm">
                <tr>
                    <th class="px-6 py-4 border-b">الاسم</th>
                    <th class="px-6 py-4 border-b">رقم الجوال</th>
                    <th class="px-6 py-4 border-b">المدينة</th>
                    <th class="px-6 py-4 border-b">السيارة</th>
                    <th class="px-6 py-4 border-b">تاريخ الطلب</th>
                    <th class="px-6 py-4 border-b">تحديث الحالة</th>
                    <th class="px-6 py-4 border-b">حذف</th>
                </tr>
            </thead>
            <tbody class="divide-y text-sm">
                @forelse($requests as $req)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-bold">{{ $req->name }}</td>
                    <td class="px-6 py-4" dir="ltr">{{ $req->phone }}</td>
                    <td class="px-6 py-4">{{ $req->city }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $req->car_model }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $req->created_at->diffForHumans() }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.captain-requests.update-status', $req->id) }}" method="POST" class="flex items-center space-x-2 space-x-reverse">
                            @csrf
                            <select name="status" class="border-gray-300 rounded text-sm py-1">
                                <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>جديد</option>
                                <option value="contacted" {{ $req->status == 'contacted' ? 'selected' : '' }}>تم التواصل</option>
                                <option value="rejected" {{ $req->status == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                            </select>
                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-bold hover:bg-blue-600">تحديث</button>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.captain-requests.destroy', $req->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟');">
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
