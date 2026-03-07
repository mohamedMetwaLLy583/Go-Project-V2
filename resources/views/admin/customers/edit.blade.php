@extends('admin.layouts.app')

@section('title', 'تعديل بيانات العميل')
@section('page-title', 'تعديل بيانات العميل: ' . $customer->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border p-8">
        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">الاسم الكامل</label>
                    <input type="text" name="name" value="{{ $customer->name }}" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">رقم الجوال</label>
                    <input type="text" name="phone" value="{{ $customer->phone }}" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ $customer->email }}" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">كلمة المرور الجديدة (اتركها فارغة إذا لم تود تغييرها)</label>
                    <input type="password" name="password" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none">
                </div>
            </div>

            <div class="flex justify-end space-x-4 space-x-reverse pt-6 border-t">
                <a href="{{ route('admin.customers.index') }}" class="px-6 py-2 bg-gray-100 text-gray-600 rounded-lg font-bold">إلغاء</a>
                <button type="submit" class="px-8 py-2 bg-yellow-500 text-white rounded-lg font-bold hover:bg-yellow-600 shadow-md transition-all">حفظ التغييرات</button>
            </div>
        </form>
    </div>
</div>
@endsection
