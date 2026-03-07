@extends('admin.layouts.app')

@section('title', 'إدارة السائقين')
@section('page-title', 'قائمة السائقين')

@section('content')
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
        <div class="flex space-x-4 space-x-reverse">
            <a href="{{ route('admin.drivers.index') }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ !request('status') ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }}">الكل</a>
            <a href="{{ route('admin.drivers.index', ['status' => 1]) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == '1' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700' }}">نشط</a>
            <a href="{{ route('admin.drivers.index', ['status' => 0]) }}" class="px-4 py-2 rounded-lg text-sm font-bold {{ request('status') == '0' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700' }}">بانتظار الموافقة</a>
        </div>
    </div>

    <table class="w-full text-right">
        <thead class="bg-gray-50 text-gray-500 text-sm">
            <tr>
                <th class="px-6 py-4 border-b">الاسم</th>
                <th class="px-6 py-4 border-b">الجوال</th>
                <th class="px-6 py-4 border-b">الجنسية</th>
                <th class="px-6 py-4 border-b">السيارة</th>
                <th class="px-6 py-4 border-b">الحالة</th>
                <th class="px-6 py-4 border-b">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($drivers as $driver)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <img src="{{ $driver->profile_picture ? url($driver->profile_picture) : 'https://ui-avatars.com/api/?name='.$driver->name }}" class="w-10 h-10 rounded-full ml-3 border">
                        <span class="font-bold text-gray-800">{{ $driver->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4">{{ $driver->phone }}</td>
                <td class="px-6 py-4">{{ $driver->nationality->name_ar ?? 'N/A' }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $driver->car_type }}</span>
                </td>
                <td class="px-6 py-4">
                    @if($driver->status == 1)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">نشط</span>
                    @else
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">معلق</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.drivers.show', $driver->id) }}" class="text-blue-600 font-bold hover:text-blue-800">تفاصيل</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="p-6 border-t">
        {{ $drivers->links() }}
    </div>
</div>
@endsection
