@extends('admin.layouts.app')

@section('title', 'إدارة الطلبات')
@section('page-title')
<div class="flex justify-between items-center w-full">
    <span>قائمة الطلبات</span>
    <a href="{{ route('admin.orders.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg text-sm font-bold transition-all shadow-md">
        + إضافة طلب جديد
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
        <div class="flex space-x-4 space-x-reverse">
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ !request('status') ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }}">الكل</a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }}">قيد الانتظار</a>
            <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == 'completed' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700' }}">مكتمل</a>
            <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == 'cancelled' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700' }}">ملغي</a>
        </div>
    </div>

    <table class="w-full text-right border-collapse">
        <thead class="bg-gray-50 text-gray-500 text-sm">
            <tr>
                <th class="px-6 py-4 border-b">رقم الطلب</th>
                <th class="px-6 py-4 border-b">العميل</th>
                <th class="px-6 py-4 border-b">المسار</th>
                <th class="px-6 py-4 border-b">السعر</th>
                <th class="px-6 py-4 border-b">الحالة</th>
                <th class="px-6 py-4 border-b">التاريخ</th>
                <th class="px-6 py-4 border-b">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y text-sm">
            @foreach($orders as $order)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 font-bold">#{{ $order->id }}</td>
                <td class="px-6 py-4">{{ $order->user->name ?? 'N/A' }}</td>
                <td class="px-6 py-4">
                    {{ $order->passengers->first()->pickup_location ?? 'unk' }} 
                    <span class="text-gray-400 mx-1">→</span> 
                    {{ $order->passengers->first()->return_location ?? 'unk' }}
                </td>
                <td class="px-6 py-4 font-bold text-green-600">{{ $order->price }} SR</td>
                <td class="px-6 py-4">
                    @php
                        $statusClasses = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            'active' => 'bg-blue-100 text-blue-800',
                        ];
                        $class = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs font-bold {{ $class }} italic">
                        {{ $order->status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('Y-m-d') }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 font-bold hover:text-blue-800">تفاصيل</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="p-6 border-t">
        {{ $orders->links() }}
    </div>
</div>
@endsection
