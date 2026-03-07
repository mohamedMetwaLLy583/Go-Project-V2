@extends('admin.layouts.app')

@section('title', 'إدارة العملاء')

@section('page-title', 'إدارة العملاء (المستخدمين)')

@section('content')
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="p-6 border-b flex justify-between items-center bg-gray-50/50">
        <h4 class="text-lg font-bold text-gray-800">قائمة العملاء المسجلين</h4>
    </div>
    
    <table class="w-full text-right">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
            <tr>
                <th class="px-8 py-4 border-b">العميل</th>
                <th class="px-8 py-4 border-b">رقم الجوال</th>
                <th class="px-8 py-4 border-b">البريد الإلكتروني</th>
                <th class="px-8 py-4 border-b">الرصيد</th>
                <th class="px-8 py-4 border-b">تاريخ التسجيل</th>
                <th class="px-8 py-4 border-b">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y relative">
            @forelse($customers as $customer)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-8 py-4">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 font-bold">
                            {{ mb_substr($customer->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-gray-800">{{ $customer->name }}</div>
                            <div class="text-[10px] text-gray-400">ID: #{{ $customer->id }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-8 py-4 text-gray-600 font-medium">{{ $customer->phone }}</td>
                <td class="px-8 py-4 text-gray-500 text-sm">{{ $customer->email }}</td>
                <td class="px-8 py-4">
                    <span class="font-bold text-green-600">{{ number_format($customer->wallet_balance, 2) }} ر.س</span>
                </td>
                <td class="px-8 py-4 text-gray-400 text-xs tracking-tighter">
                    {{ $customer->created_at->format('Y/m/d') }}
                </td>
                <td class="px-8 py-4">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <a href="{{ route('admin.customers.show', $customer->id) }}" class="text-gray-400 hover:text-blue-600 transition-colors">
                           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="text-gray-400 hover:text-yellow-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟ لا يمكن التراجع!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-8 py-12 text-center text-gray-400 italic">لا يوجد عملاء مسجلين حالياً</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="px-8 py-4 bg-gray-50 border-t">
        {{ $customers->links() }}
    </div>
</div>
@endsection
