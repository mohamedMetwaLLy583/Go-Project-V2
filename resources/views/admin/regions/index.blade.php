@extends('admin.layouts.app')

@section('title', 'إدارة المناطق')

@section('page-title')
<div class="flex justify-between items-center w-full">
    <span>إدارة المناطق الجغرافية</span>
    <a href="{{ route('admin.regions.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg text-sm font-bold transition-all shadow-md">
        + إضافة منطقة جديدة
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <table class="w-full text-right">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
            <tr>
                <th class="px-8 py-4 border-b">اسم المنطقة (AR)</th>
                <th class="px-8 py-4 border-b">اسم المنطقة (EN)</th>
                <th class="px-8 py-4 border-b">عدد الأحياء</th>
                <th class="px-8 py-4 border-b">الحالة</th>
                <th class="px-8 py-4 border-b">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($regions as $region)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-8 py-4 font-bold text-gray-700">{{ $region->name_ar }}</td>
                <td class="px-8 py-4 text-gray-500">{{ $region->name_en }}</td>
                <td class="px-8 py-4">
                    <a href="{{ route('admin.regions.neighborhoods', $region->id) }}" class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-xs font-bold hover:bg-blue-100">
                        {{ $region->neighborhoods_count }} أحياء (إدارة)
                    </a>
                </td>
                <td class="px-8 py-4">
                    <span class="px-2 py-1 {{ $region->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded text-[10px] font-bold">
                        {{ $region->is_active ? 'نشط' : 'معطل' }}
                    </span>
                </td>
                <td class="px-8 py-4">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <a href="{{ route('admin.regions.edit', $region->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm">تعديل</a>
                        <form action="{{ route('admin.regions.destroy', $region->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟ سيتم حذف كافة الأحياء المرتبطة!')">
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
