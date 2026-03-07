@extends('admin.layouts.app')

@section('title', 'لوحة التحكم')
@section('page-title', 'الرئيسية')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Customers -->
    <div class="bg-white rounded-xl shadow-sm border p-6 transition-transform hover:scale-105">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">إجمالي العملاء</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_customers'] }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-lg text-2xl">👥</div>
        </div>
    </div>

    <!-- Total Drivers -->
    <div class="bg-white rounded-xl shadow-sm border p-6 transition-transform hover:scale-105">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">إجمالي السائقين</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_drivers'] }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-lg text-2xl">🚗</div>
        </div>
    </div>

    <!-- Pending Drivers -->
    <div class="bg-white rounded-xl shadow-sm border p-6 border-yellow-200 transition-transform hover:scale-105">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">سائقون بانتظار الموافقة</p>
                <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pending_drivers'] }}</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-lg text-2xl">⏳</div>
        </div>
        <a href="{{ route('admin.drivers.index', ['status' => 'pending']) }}" class="text-sm text-blue-600 hover:underline mt-4 inline-block font-semibold">عرض الطلبات ←</a>
    </div>

    <!-- Pending Orders -->
    <div class="bg-white rounded-xl shadow-sm border p-6 border-purple-200 transition-transform hover:scale-105">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-semibold">طلبات قيد الانتظار</p>
                <p class="text-3xl font-bold text-purple-600 mt-2">{{ $stats['pending_orders'] }}</p>
            </div>
            <div class="bg-purple-100 p-3 rounded-lg text-2xl">📦</div>
        </div>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="text-sm text-blue-600 hover:underline mt-4 inline-block font-semibold">عرض الكل ←</a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <p class="text-gray-500 text-sm font-semibold">تذاكر الدعم المفتوحة</p>
        <p class="text-3xl font-bold text-red-600 mt-2">{{ $stats['open_tickets'] }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border p-6">
        <p class="text-gray-500 text-sm font-semibold">إجمالي مبالغ المحافظ</p>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($stats['total_balance'], 2) }} <span class="text-sm font-normal">SR</span></p>
    </div>
</div>

<!-- Recent Activities -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Drivers -->
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">آخر السائقين المتقدمين</h3>
        </div>
        <div class="divide-y">
            @forelse($recentDrivers as $driver)
            <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-200 ml-3 flex items-center justify-center font-bold text-gray-500">
                        {{ mb_substr($driver->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-800">{{ $driver->name }}</p>
                        <p class="text-sm text-gray-500">{{ $driver->phone }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $driver->status == 1 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $driver->status == 1 ? 'مفعل' : 'بانتظار الموافقة' }}
                </span>
            </div>
            @empty
            <p class="p-8 text-center text-gray-500">لا يوجد سائقون حالياً</p>
            @endforelse
        </div>
        <div class="p-4 bg-gray-50 text-center border-t">
            <a href="{{ route('admin.drivers.index') }}" class="text-blue-600 font-bold hover:underline">عرض جميع السائقين</a>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">آخر الطلبات المنشأة</h3>
        </div>
        <div class="divide-y">
            @forelse($recentOrders as $order)
            <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                <div>
                    <p class="font-bold text-gray-800">طلب #{{ $order->id }}</p>
                    <p class="text-sm text-gray-500">بواسطة: {{ $order->user->name ?? 'عميل' }}</p>
                </div>
                <div class="text-left">
                    <p class="text-green-600 font-bold">{{ $order->price }} SR</p>
                    <span class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @empty
            <p class="p-8 text-center text-gray-500">لا توجد طلبات بعد</p>
            @endforelse
        </div>
        <div class="p-4 bg-gray-50 text-center border-t">
            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 font-bold hover:underline">عرض قائمة الطلبات</a>
        </div>
    </div>
</div>

<!-- Support Tickets -->
<div class="mt-8 bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800">تذاكر الدعم الفني الأخيرة</h3>
        <a href="{{ route('admin.tickets.index') }}" class="text-blue-600 text-sm font-bold hover:underline">عرض الكل</a>
    </div>
    <table class="w-full text-right border-collapse">
        <thead class="bg-gray-50 text-gray-500 text-sm">
            <tr>
                <th class="px-6 py-3 border-b">العميل</th>
                <th class="px-6 py-3 border-b">الموضوع</th>
                <th class="px-6 py-3 border-b">الأولوية</th>
                <th class="px-6 py-3 border-b">الحالة</th>
                <th class="px-6 py-3 border-b">التاريخ</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($recentTickets as $ticket)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $ticket->user->name }}</td>
                <td class="px-6 py-4 font-bold">{{ $ticket->subject }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs {{ $ticket->priority == 'high' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $ticket->priority }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">
                        {{ $ticket->status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-500 text-sm">{{ $ticket->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
