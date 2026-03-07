@extends('admin.layouts.app')

@section('title', 'تذاكر الدعم الفني')
@section('page-title', 'الدعم الفني')

@section('content')
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="p-6 border-b bg-gray-50 flex space-x-4 space-x-reverse">
        <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ !request('status') ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }}">الكل</a>
        <a href="{{ route('admin.tickets.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }}">بانتظار المراجعة</a>
        <a href="{{ route('admin.tickets.index', ['status' => 'open']) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == 'open' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">مفتوحة</a>
        <a href="{{ route('admin.tickets.index', ['status' => 'closed']) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == 'closed' ? 'bg-gray-500 text-white' : 'bg-gray-200 text-gray-700' }}">مغلقة</a>
    </div>

    <table class="w-full text-right border-collapse">
        <thead class="bg-gray-50 text-gray-500 text-sm">
            <tr>
                <th class="px-6 py-4 border-b">العميل</th>
                <th class="px-6 py-4 border-b">الموضوع</th>
                <th class="px-6 py-4 border-b">الأولوية</th>
                <th class="px-6 py-4 border-b">الحالة</th>
                <th class="px-6 py-4 border-b">التاريخ</th>
                <th class="px-6 py-4 border-b">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y text-sm">
            @foreach($tickets as $ticket)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">{{ $ticket->user->name ?? 'unk' }}</td>
                <td class="px-6 py-4 font-bold">{{ $ticket->subject }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs {{ $ticket->priority == 'high' ? 'bg-red-100 text-red-800' : ($ticket->priority == 'medium' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ $ticket->priority }}
                    </span>
                </td>
                <td class="px-6 py-4 text-xs font-bold">{{ $ticket->status }}</td>
                <td class="px-6 py-4 text-gray-500">{{ $ticket->created_at->diffForHumans() }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="text-blue-600 font-bold hover:underline">عرض</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="p-6 border-t font-semibold">
        {{ $tickets->links() }}
    </div>
</div>
@endsection
