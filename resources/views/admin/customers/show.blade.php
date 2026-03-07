@extends('admin.layouts.app')

@section('title', 'ملف العميل')
@section('page-title', 'ملف العميل: ' . $customer->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1 space-y-8">
        <!-- Basic Info Card -->
        <div class="bg-white rounded-xl shadow-sm border p-8 text-center">
            <div class="w-24 h-24 rounded-full bg-yellow-100 flex items-center justify-center text-3xl text-yellow-600 font-bold mx-auto mb-4 border-4 border-white shadow-sm">
                {{ mb_substr($customer->name, 0, 1) }}
            </div>
            <h4 class="text-xl font-black text-gray-800">{{ $customer->name }}</h4>
            <p class="text-gray-400 text-sm mb-6">عميل منذ {{ $customer->created_at->format('Y-m-d') }}</p>
            
            <div class="grid grid-cols-2 gap-4 border-t pt-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-[10px] text-gray-400 font-bold uppercase mb-1">الرصيد الحقيقي</div>
                    <div class="text-lg font-black text-green-600">{{ number_format($customer->wallet_balance, 2) }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-[10px] text-gray-400 font-bold uppercase mb-1">النقاط (Coins)</div>
                    <div class="text-lg font-black text-yellow-600">{{ $customer->coins ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="bg-white rounded-xl shadow-sm border p-8 space-y-4">
            <h5 class="text-sm font-black text-gray-800 border-b pb-2 mb-4 uppercase tracking-widest">معلومات التواصل</h5>
            <div class="flex items-center space-x-3 space-x-reverse">
                <span class="w-8 h-8 rounded bg-blue-50 text-blue-500 flex items-center justify-center italic text-xs">@</span>
                <span class="text-gray-600 text-sm font-medium">{{ $customer->email }}</span>
            </div>
            <div class="flex items-center space-x-3 space-x-reverse">
                <span class="w-8 h-8 rounded bg-green-50 text-green-500 flex items-center justify-center text-xs">📞</span>
                <span class="text-gray-600 text-sm font-medium">{{ $customer->phone }}</span>
            </div>
            @if($customer->nationality)
            <div class="flex items-center space-x-3 space-x-reverse">
                <span class="w-8 h-8 rounded bg-purple-50 text-purple-500 flex items-center justify-center text-xs">🌍</span>
                <span class="text-gray-600 text-sm font-medium">{{ $customer->nationality->name_ar }}</span>
            </div>
            @endif
        </div>
    </div>

    <div class="lg:col-span-2 space-y-8">
        <!-- Statistics / Activity -->
        <div class="bg-white rounded-xl shadow-sm border p-8">
            <h4 class="text-lg font-black text-gray-800 mb-6 border-b pb-4">ملخص النشاط</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="border rounded-2xl p-6 hover:border-yellow-500 transition-colors">
                    <div class="text-3xl font-black text-gray-800 mb-1">{{ \App\Models\Order::where('user_id', $customer->id)->count() }}</div>
                    <div class="text-xs text-gray-400 font-bold uppercase tracking-widest">إجمالي الطلبات</div>
                </div>
                <div class="border rounded-2xl p-6 hover:border-green-500 transition-colors">
                    <div class="text-3xl font-black text-gray-800 mb-1">{{ \App\Models\Order::where('user_id', $customer->id)->where('status', 'completed')->count() }}</div>
                    <div class="text-xs text-gray-400 font-bold uppercase tracking-widest">طلبات مكتملة</div>
                </div>
                <div class="border rounded-2xl p-6 hover:border-blue-500 transition-colors">
                    <div class="text-3xl font-black text-gray-800 mb-1">{{ \App\Models\SupportTicket::where('user_id', $customer->id)->count() }}</div>
                    <div class="text-xs text-gray-400 font-bold uppercase tracking-widest">تذاكر الدعم</div>
                </div>
            </div>
        </div>

        <!-- Latest Orders Table -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="p-6 border-b flex justify-between items-center bg-gray-50/50">
                <h4 class="text-sm font-bold text-gray-800 uppercase tracking-widest">آخر الطلبات المقدمة</h4>
                <a href="{{ route('admin.orders.index', ['user_id' => $customer->id]) }}" class="text-xs text-blue-600 font-black hover:underline">عرض الكل</a>
            </div>
            <table class="w-full text-right">
                <thead class="bg-gray-50 text-gray-400 text-[10px] uppercase font-bold tracking-widest">
                    <tr>
                        <th class="px-6 py-4">رقم الطلب</th>
                        <th class="px-6 py-4">التاريخ</th>
                        <th class="px-6 py-4">السعر</th>
                        <th class="px-6 py-4">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-sm">
                    @forelse(\App\Models\Order::where('user_id', $customer->id)->latest()->take(5)->get() as $order)
                    <tr>
                        <td class="px-6 py-4 font-bold text-gray-700">#{{ $order->id }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 font-bold">{{ number_format($order->price, 2) }} ر.س</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-gray-100 rounded text-[10px] uppercase font-black text-gray-500">{{ $order->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">لا توجد طلبات سابقة</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
