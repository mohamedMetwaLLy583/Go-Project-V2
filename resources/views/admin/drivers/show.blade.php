@extends('admin.layouts.app')

@section('title', 'تفاصيل السائق')
@section('page-title', 'بيانات السائق: ' . $driver->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="p-8 text-center border-b">
                <img src="{{ $driver->profile_picture ? url($driver->profile_picture) : 'https://ui-avatars.com/api/?name='.$driver->name }}" class="w-32 h-32 rounded-full mx-auto border-4 border-gray-100 shadow-sm">
                <h3 class="text-2xl font-bold text-gray-800 mt-4">{{ $driver->name }}</h3>
                <p class="text-gray-500">{{ $driver->phone }}</p>
                <div class="mt-4 flex justify-center space-x-2 space-x-reverse">
                    @if($driver->status == 1)
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-bold">حساب نشط</span>
                    @else
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-bold">بانتظار التفعيل</span>
                    @endif
                </div>
            </div>
            <div class="p-6 bg-gray-50">
                <form action="{{ route('admin.drivers.update-status', $driver->id) }}" method="POST">
                    @csrf
                    <label class="block text-sm font-bold text-gray-700 mb-2">تحديث الحالة</label>
                    <select name="status" class="w-full border rounded-lg p-2 mb-4">
                        <option value="1" {{ $driver->status == 1 ? 'selected' : '' }}>تفعيل الحساب</option>
                        <option value="0" {{ $driver->status == 0 ? 'selected' : '' }}>تعليق الحساب</option>
                    </select>
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition-colors">حفظ التغيير</button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border mt-6 p-6">
            <h4 class="font-bold text-gray-800 mb-4">المحفظة والرصيد</h4>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-500">الرصيد النقدي:</span>
                <span class="font-bold text-green-600">{{ $driver->wallet_balance }} SR</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500">الكوينز:</span>
                <span class="font-bold text-yellow-600">{{ $driver->coins }} 🪙</span>
            </div>
        </div>
    </div>

    <!-- Details Tabs -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border p-8">
            <h4 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">المعلومات الشخصية والسيارة</h4>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">الجنسية</p>
                    <p class="font-bold">{{ $driver->nationality->name_ar ?? 'غير محدد' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">العمر</p>
                    <p class="font-bold">{{ $driver->age }} سنة</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">نوع السيارة</p>
                    <p class="font-bold">{{ $driver->car_type == 'separated' ? 'فاصل (مظللة/معزولة)' : 'عادية' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">تفضيلات القيادة</p>
                    <div class="flex flex-wrap gap-2 mt-1">
                        @if($driver->accept_smoking)
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded">يسمح بالتدخين</span>
                        @endif
                        @if($driver->accept_others)
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded">يسمح بركاب إضافيين</span>
                        @endif
                    </div>
                </div>
            </div>

            <h4 class="text-xl font-bold text-gray-800 mt-10 mb-6 border-b pb-4">صور السيارة</h4>
            <div class="grid grid-cols-3 gap-4">
                @forelse($driver->carImages as $image)
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden border">
                        <img src="{{ url($image->image_path) }}" class="w-full h-full object-cover">
                    </div>
                @empty
                    <p class="text-gray-400">لا توجد صور مرفوعة</p>
                @endforelse
            </div>

            <h4 class="text-xl font-bold text-gray-800 mt-10 mb-6 border-b pb-4">المناطق المتاحة (Zones)</h4>
            <div class="space-y-4">
                @forelse($driver->driverAvailability as $avail)
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <div>
                            <span class="font-bold text-blue-600">{{ $avail->day->name_ar ?? 'يوم' }}</span>
                            <span class="mx-2">|</span>
                            <span>{{ $avail->neighborhood->name_ar ?? 'حي' }} ({{ $avail->neighborhood->zone ?? 'بدون منطقة' }})</span>
                        </div>
                        <div class="text-sm text-gray-500">
                            من {{ $avail->start_time }} إلى {{ $avail->end_time }}
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400">لم يتم تحديد مناطق عمل</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
