@extends('admin.layouts.app')

@section('title', 'إدارة أحياء ' . $region->name_ar)

@section('page-title')
<div class="flex justify-between items-center w-full">
    <span>إدارة أحياء منطقة: {{ $region->name_ar }}</span>
    <a href="{{ route('admin.regions.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-bold">← العودة للمناطق</a>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- List Neighborhoods -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <table class="w-full text-right">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 border-b">اسم الحي (AR)</th>
                        <th class="px-6 py-4 border-b">المدينة</th>
                        <th class="px-6 py-4 border-b">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($neighborhoods as $neighborhood)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-700">{{ $neighborhood->name_ar }}</td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $neighborhood->city->name_ar ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.neighborhoods.destroy', $neighborhood->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الحي؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-widest">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($neighborhoods->isEmpty())
                <div class="p-12 text-center text-gray-400 italic">لا توجد أحياء مرتبطة بهذه المنطقة حالياً</div>
            @endif
        </div>
    </div>

    <!-- Add Neighborhood Form -->
    <div>
        <div class="bg-white rounded-xl shadow-sm border p-6 sticky top-8">
            <h4 class="text-lg font-black text-gray-800 mb-6 border-b pb-4">إضافة حي جديد للمنطقة</h4>
            <form action="{{ route('admin.regions.neighborhoods.store', $region->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-widest">اختيار المدينة</label>
                    <select name="city_id" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-yellow-500 outline-none bg-gray-50 text-sm" required>
                        <option value="">اختر المدينة...</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ $city->name_ar == 'الرياض' ? 'selected' : '' }}>{{ $city->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-widest">اسم الحي (AR)</label>
                    <input type="text" name="name_ar" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-yellow-500 outline-none text-sm" placeholder="مثال: حي الملقا" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-widest">اسم الحي (EN)</label>
                    <input type="text" name="name_en" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-yellow-500 outline-none text-sm" placeholder="Example: Al Malqa">
                </div>
                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg font-black shadow-lg transition-all mt-4">
                    إضافة الحي الآن
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
