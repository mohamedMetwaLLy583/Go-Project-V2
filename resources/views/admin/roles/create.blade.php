@extends('admin.layouts.app')

@section('title', 'إضافة دور')
@section('page-title', 'إضافة دور جديد وتحديد صلاحياته')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border p-8">
        <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-8">
            @csrf
            <div>
                <label class="block text-sm font-black text-gray-700 mb-2">اسم الدور (الوظيفي)</label>
                <input type="text" name="name" class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-yellow-500 outline-none bg-gray-50" placeholder="مثال: مدير عمليات / موظف دعم" required>
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-black text-gray-700 border-b pb-2">تحديد الصلاحيات</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($availablePermissions as $key => $label)
                    <label class="flex items-center p-4 bg-gray-50 rounded-xl border cursor-pointer hover:bg-white transition-all group">
                        <input type="checkbox" name="permissions[]" value="{{ $key }}" class="w-5 h-5 text-yellow-500 rounded border-gray-300 focus:ring-yellow-500 ml-3">
                        <div>
                            <p class="text-sm font-bold text-gray-800 group-hover:text-yellow-600">{{ $label }}</p>
                            <p class="text-[10px] text-gray-400">السماح بالوصول إلى قسم {{ $label }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end space-x-4 space-x-reverse pt-6 border-t">
                <a href="{{ route('admin.roles.index') }}" class="px-8 py-3 bg-gray-100 text-gray-600 rounded-lg font-bold">إلغاء</a>
                <button type="submit" class="px-8 py-3 bg-yellow-500 text-white rounded-lg font-black shadow-lg hover:shadow-xl transition-all">حفظ الدور الجديد</button>
            </div>
        </form>
    </div>
</div>
@endsection
