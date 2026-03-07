@extends('admin.layouts.app')

@section('title', 'إدارة الموظفين')

@section('page-title')
<div class="flex justify-between items-center w-full">
    <span>إدارة موظفي الإدارة</span>
    <a href="{{ route('admin.staff.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg text-sm font-bold transition-all shadow-md">
        + إضافة موظف جديد
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <table class="w-full text-right">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
            <tr>
                <th class="px-8 py-4 border-b">الاسم</th>
                <th class="px-8 py-4 border-b">البريد الإلكتروني</th>
                <th class="px-8 py-4 border-b">الدور / الصلاحية</th>
                <th class="px-8 py-4 border-b">تاريخ الانضمام</th>
                <th class="px-8 py-4 border-b">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($staff as $member)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-8 py-4 font-bold text-gray-700">{{ $member->name }}</td>
                <td class="px-8 py-4 text-gray-500">{{ $member->email }}</td>
                <td class="px-8 py-4">
                    <span class="px-3 py-1 {{ $member->role ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700' }} rounded-full text-[10px] font-black uppercase">
                        {{ $member->role->name ?? 'مدير عام (Super Admin)' }}
                    </span>
                </td>
                <td class="px-8 py-4 text-gray-400 text-xs">{{ $member->created_at->format('Y-m-d') }}</td>
                <td class="px-8 py-4">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <a href="{{ route('admin.staff.edit', $member->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm">تعديل</a>
                        @if($member->id !== auth()->id())
                        <form action="{{ route('admin.staff.destroy', $member->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموظف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm">حذف</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
