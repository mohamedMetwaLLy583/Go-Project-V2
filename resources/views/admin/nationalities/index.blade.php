@extends('admin.layouts.app')

@section('title', 'إدارة الجنسيات')

@section('page-title')
<div class="flex justify-between items-center w-full">
    <span>إدارة الجنسيات</span>
    <a href="{{ route('admin.nationalities.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg text-sm font-bold transition-all shadow-md">
        + إضافة جنسية جديدة
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <table class="w-full text-right">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
            <tr>
                <th class="px-8 py-4 border-b">اسم الجنسية (AR)</th>
                <th class="px-8 py-4 border-b">اسم الجنسية (EN)</th>
                <th class="px-8 py-4 border-b">عدد المستخدمين</th>
                <th class="px-8 py-4 border-b">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($nationalities as $nationality)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-8 py-4 font-bold text-gray-700">{{ $nationality->name_ar }}</td>
                <td class="px-8 py-4 text-gray-500">{{ $nationality->name_en }}</td>
                <td class="px-8 py-4">
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold">
                        {{ $nationality->users()->count() }}
                    </span>
                </td>
                <td class="px-8 py-4">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <a href="{{ route('admin.nationalities.edit', $nationality->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm">تعديل</a>
                        <form action="{{ route('admin.nationalities.destroy', $nationality->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm">حذف</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
