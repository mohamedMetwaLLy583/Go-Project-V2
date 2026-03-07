@extends('admin.layouts.app')

@section('title', 'تفاصيل الطلب')
@section('page-title', 'الطلب رقم #' . $order->id)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
    <div class="lg:col-span-2 space-y-8">
        <!-- Order Context Header -->
        <div class="bg-white rounded-xl shadow-sm border p-8">
            <div class="flex flex-wrap justify-between items-center gap-4 mb-6 border-b pb-6">
                <div class="flex items-center">
                    <div class="w-14 h-14 {{ $order->is_urgent ? 'bg-red-100' : 'bg-blue-100' }} rounded-xl flex items-center justify-center text-2xl ml-4">
                        {{ $order->is_urgent ? '⚡' : '📅' }}
                    </div>
                    <div>
                        <h4 class="text-2xl font-black text-gray-800 flex items-center">
                            {{ $order->shift_type == 'fixed' ? 'دوام ثابت' : 'دوام متغير' }}
                            @if($order->is_urgent)
                                <span class="mr-3 px-2 py-0.5 bg-red-500 text-white text-[10px] rounded-full animate-pulse">عاجل</span>
                            @endif
                        </h4>
                        <p class="text-gray-400 text-sm font-medium">تم النشر في: {{ $order->created_at->format('Y-m-d | H:i') }}</p>
                    </div>
                </div>
                <div class="flex flex-col items-end">
                    <span class="px-6 py-2 rounded-full text-xs font-black tracking-widest uppercase {{ 
                        $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                        ($order->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700') 
                    }} border border-current opacity-70 mb-2">
                        {{ $order->status == 'pending' ? 'بانتظار سائق' : ($order->status == 'active' ? 'نشط حالياً' : $order->status) }}
                    </span>
                    <p class="text-[10px] font-bold text-gray-400">كود الطلب: <span class="text-gray-600">ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="p-4 bg-gray-50 rounded-lg border text-center">
                    <p class="text-[10px] text-gray-400 font-bold mb-1">نوع الرحلة</p>
                    <p class="font-black text-gray-700 text-sm">
                        {{ $order->trip_type == 'round_trip' ? 'ذهاب وعودة' : ($order->trip_type == 'go_only' ? 'ذهاب فقط' : 'عودة فقط') }}
                    </p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg border text-center">
                    <p class="text-[10px] text-gray-400 font-bold mb-1">المسافة</p>
                    <p class="font-black text-gray-700 text-sm">{{ $order->distance_km ?? '0' }} كم</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg border text-center">
                    <p class="text-[10px] text-gray-400 font-bold mb-1">تاريخ البدء</p>
                    <p class="font-black text-gray-700 text-sm">{{ $order->start_date ?? 'لم يحدد' }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg border text-center">
                    <p class="text-[10px] text-gray-400 font-bold mb-1">الركاب</p>
                    <p class="font-black text-gray-700 text-sm">{{ $order->passengers->count() }} ركاب</p>
                </div>
            </div>

            <!-- New Fields Display -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
                <div class="space-y-4">
                    <h5 class="text-xs font-black text-gray-400 uppercase tracking-widest border-r-2 border-yellow-500 pr-2">تفضيلات السيارة</h5>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-gray-100 rounded-md text-[10px] font-bold {{ $order->needs_ac ? 'text-blue-600' : 'text-gray-400 line-through' }}">❄️ تكييف</span>
                        <span class="px-3 py-1 bg-gray-100 rounded-md text-[10px] font-bold {{ $order->tinted_glass ? 'text-gray-800' : 'text-gray-400 line-through' }}">🕶️ زجاج مظلل</span>
                        <span class="px-3 py-1 bg-gray-100 rounded-md text-[10px] font-bold {{ $order->is_shared ? 'text-green-600' : 'text-gray-400 line-through' }}">👥 رحلة مشتركة</span>
                        <span class="px-3 py-1 bg-gray-100 rounded-md text-[10px] font-bold text-gray-600">🚗 {{ $order->car_condition == 'new' ? 'سيارة حديثة' : 'سيارة عادية' }}</span>
                    </div>
                </div>
                <div class="space-y-4">
                    <h5 class="text-xs font-black text-gray-400 uppercase tracking-widest border-r-2 border-blue-500 pr-2">أيام العمل والإجازة</h5>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <span class="text-[10px] font-bold text-gray-400 w-16">العمل:</span>
                            <div class="flex flex-wrap gap-1">
                                @php $days = json_decode($order->delivery_days, true) ?? []; @endphp
                                @foreach($days as $day)
                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[9px] font-black rounded">{{ $day }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex items-center">
                            <span class="text-[10px] font-bold text-gray-400 w-16">الإجازة:</span>
                            <div class="flex flex-wrap gap-1">
                                @php $v_days = json_decode($order->vacation_days, true) ?? []; @endphp
                                @foreach($v_days as $day)
                                    <span class="px-2 py-0.5 bg-red-50 text-red-600 text-[9px] font-black rounded">{{ $day }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Passengers & Path Timeline -->
        <div class="bg-white rounded-xl shadow-sm border p-8">
            <h4 class="text-xl font-black text-gray-800 mb-8 border-b pb-4">مخطط سير الركاب</h4>
            <div class="space-y-12">
                @foreach($order->passengers as $index => $passenger)
                <div class="relative pr-8 border-r-2 border-gray-100 pb-4">
                    <div class="absolute -right-[11px] top-0 w-5 h-5 bg-yellow-500 rounded-full border-4 border-white shadow-sm"></div>
                    <div class="flex flex-wrap items-center justify-between mb-4">
                        <h5 class="font-black text-gray-800 text-lg flex items-center">
                            الراكب #{{ $index + 1 }}: {{ $passenger->name }}
                            <span class="mr-3 px-2 py-0.5 bg-gray-100 text-gray-500 text-[9px] font-bold rounded uppercase">
                                {{ $passenger->type == 'male' ? 'رجل' : ($passenger->type == 'female' ? 'سيدة' : 'طالب/طفل') }}
                            </span>
                        </h5>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Pickup Block -->
                        <div class="bg-blue-50/50 p-6 rounded-2xl border border-blue-100 relative overflow-hidden group">
                            <div class="absolute top-0 left-0 w-2 h-full bg-blue-500/20 group-hover:bg-blue-500/40 transition-colors"></div>
                            <div class="flex items-center mb-4">
                                <span class="bg-blue-500 text-white w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-bold ml-3 shadow-md shadow-blue-200">↑</span>
                                <h6 class="text-xs font-black text-blue-700 uppercase tracking-widest">تجمع/بداية ({{ $passenger->pickup_location_type }})</h6>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <span class="text-gray-400 ml-2 mt-1">📍</span>
                                    <div>
                                        <p class="font-black text-gray-700 text-sm">{{ $passenger->pickup_location }}</p>
                                        <p class="text-[10px] text-gray-400 font-bold mt-1">حي {{ $passenger->pickup_neighborhood ?? 'غير محدد' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 mt-4 pt-4 border-t border-blue-100/50">
                                    <div>
                                        <p class="text-[9px] text-blue-400 font-bold uppercase mb-1">وصول السائق</p>
                                        <p class="font-black text-blue-700 text-sm tracking-tighter">{{ $passenger->driver_arrival_time ?? '00:00' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] text-blue-400 font-bold uppercase mb-1">بداية الدوام</p>
                                        <p class="font-black text-blue-700 text-sm tracking-tighter">{{ $passenger->work_start_time ?? '00:00' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Return Block -->
                        <div class="bg-red-50/50 p-6 rounded-2xl border border-red-100 relative overflow-hidden group">
                            <div class="absolute top-0 left-0 w-2 h-full bg-red-500/20 group-hover:bg-red-500/40 transition-colors"></div>
                            <div class="flex items-center mb-4">
                                <span class="bg-red-500 text-white w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-bold ml-3 shadow-md shadow-red-200">↓</span>
                                <h6 class="text-xs font-black text-red-700 uppercase tracking-widest">انتهاء/عودة ({{ $passenger->return_location_type }})</h6>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <span class="text-gray-400 ml-2 mt-1">🏁</span>
                                    <div>
                                        <p class="font-black text-gray-700 text-sm">{{ $passenger->return_location ?? 'لم يحدد' }}</p>
                                        <p class="text-[10px] text-gray-400 font-bold mt-1">حي {{ $passenger->return_neighborhood ?? 'غير محدد' }}</p>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-red-100/50 text-left">
                                    <p class="text-[9px] text-red-400 font-bold uppercase mb-1">موعد الخروج</p>
                                    <p class="font-black text-red-700 text-sm tracking-tighter">{{ $passenger->return_time ? $passenger->return_time->format('H:i') : '00:00' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @if($order->notes)
        <div class="bg-yellow-50 rounded-xl p-8 border border-yellow-100">
            <h5 class="text-xs font-black text-yellow-700 uppercase tracking-widest mb-4 flex items-center">
                <span class="ml-2">📝</span> ملاحظات إضافية
            </h5>
            <p class="text-gray-700 leading-relaxed font-medium bg-white/50 p-4 rounded-lg border border-yellow-200/50 shadow-inner italic">
                "{{ $order->notes }}"
            </p>
        </div>
        @endif
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Client Card -->
        <div class="bg-white rounded-2xl shadow-sm border p-8 space-y-6">
            <h4 class="font-black text-gray-800 border-b pb-4 flex items-center justify-between">
                صاحب الطلب
                <span class="text-[10px] px-2 py-1 bg-gray-100 rounded text-gray-400 font-bold">{{ $order->user->nationality->name_ar ?? 'سعودي' }}</span>
            </h4>
            <div class="flex items-center">
                <div class="relative">
                    <div class="w-16 h-16 bg-gradient-to-tr from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center text-2xl shadow-lg ring-4 ring-yellow-50 ml-4 overflow-hidden">
                        @if($order->user->profile_picture)
                            <img src="{{ url($order->user->profile_picture) }}" class="w-full h-full object-cover">
                        @else
                            👤
                        @endif
                    </div>
                    <div class="absolute -bottom-1 -left-1 w-6 h-6 bg-green-500 border-4 border-white rounded-full"></div>
                </div>
                <div>
                    <p class="font-black text-gray-800 text-lg leading-tight">{{ $order->user->name ?? 'غير معروف' }}</p>
                    <p class="text-sm text-gray-400 font-bold mt-1 tracking-tight">{{ $order->user->phone ?? 'لا يتوفر رقم' }}</p>
                </div>
            </div>
        </div>

        <!-- Financial Card -->
        <div class="bg-gray-900 rounded-2xl shadow-xl p-8 text-white relative overflow-hidden group">
            <div class="absolute -top-10 -left-10 w-32 h-32 bg-yellow-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
            <h4 class="font-black text-lg mb-8 flex justify-between items-center relative">
                التفاصيل المالية
                <span class="text-[8px] tracking-[4px] opacity-30 uppercase font-black italic">Invoice</span>
            </h4>
            <div class="space-y-5 relative">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-[10px] font-bold uppercase">الراتب الشهري (للعميل)</span>
                    <span class="font-black text-xl text-yellow-400">{{ $order->salary ?? '0' }} <small class="text-[10px] mr-1">SR</small></span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-500 font-bold italic">سعر الرحلة الواحدة</span>
                    <span class="font-bold text-gray-300">{{ $order->price }} SR</span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-500 font-bold italic">عمولة التطبيق (10%)</span>
                    <span class="font-bold text-red-400">- {{ $order->app_commission }} SR</span>
                </div>
                <div class="border-t border-gray-800 mt-6 pt-6 flex justify-between items-end">
                    <div>
                        <p class="text-[8px] font-black text-gray-500 uppercase leading-none mb-1">صافي السائق / رحلة</p>
                        <p class="text-xs text-gray-400 font-bold italic">Net per trip</p>
                    </div>
                    <span class="font-black text-3xl bg-clip-text text-transparent bg-gradient-to-r from-white to-gray-400">
                        {{ $order->price - $order->app_commission }}
                        <small class="text-[10px] mr-1 text-gray-500">SR</small>
                    </span>
                </div>
            </div>
        </div>

        <!-- Driver Selection / Requests Summary -->
        @if($order->selectedDriver)
        <div class="bg-gradient-to-br from-green-50 to-white rounded-2xl shadow-sm border border-green-100 p-8">
            <h4 class="font-black text-green-800 mb-6 border-b border-green-100 pb-4 flex items-center">
                <span class="bg-green-100 w-6 h-6 rounded flex items-center justify-center ml-2 text-xs">✔️</span>
                السائق المتعاقد
            </h4>
            <div class="flex items-center">
                <div class="w-12 h-12 bg-white rounded-xl border border-green-200 flex items-center justify-center text-xl ml-4 shadow-sm">🚖</div>
                <div>
                    <p class="font-black text-gray-800 leading-none">{{ $order->selectedDriver->name }}</p>
                    <p class="text-xs text-green-600 font-black mt-2 tracking-tighter">{{ $order->selectedDriver->phone }}</p>
                </div>
            </div>
            <a href="{{ route('admin.drivers.show', $order->selectedDriver->id) }}" class="mt-6 block text-center py-2 bg-green-600 text-white text-[10px] font-black rounded-lg hover:bg-green-700 transition-colors uppercase tracking-widest">ملف السائق</a>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-sm border p-8">
            <h4 class="font-black text-gray-800 mb-6 border-b pb-4">موجز التقديم</h4>
            <div class="flex items-center justify-between">
                <div class="text-center flex-1">
                    <p class="text-2xl font-black text-blue-600">{{ $order->driverRequests->count() }}</p>
                    <p class="text-[9px] font-black text-gray-400 uppercase">عروض مقدمة</p>
                </div>
                <div class="w-[1px] h-8 bg-gray-100 mx-4"></div>
                <div class="text-center flex-1">
                    <p class="text-2xl font-black text-gray-300">0</p>
                    <p class="text-[9px] font-black text-gray-400 uppercase">مرفوضة</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Action Card -->
        <div class="bg-white rounded-2xl shadow-sm border p-8">
            <h4 class="font-black text-gray-800 mb-6 flex items-center">
                <span class="w-2 h-2 bg-yellow-400 rounded-full ml-3"></span>
                إجراءات الإدارة
            </h4>
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block">الحالة التشغيلية</label>
                    <select name="status" class="w-full border rounded-xl p-3 bg-gray-50 text-xs font-black focus:ring-2 focus:ring-yellow-500 outline-none">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>🔍 بحث عن سواق</option>
                        <option value="active" {{ $order->status == 'active' ? 'selected' : '' }}>✅ نشط (جاري التوصيل)</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>🏁 تم الإنجاز</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ إلغاء الطلب</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-gray-900 text-white font-black py-4 rounded-xl shadow-lg hover:shadow-yellow-500/20 hover:bg-black transition-all transform hover:-translate-y-1 active:scale-95 text-xs">
                    تحديث الحالة
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    @font-face {
        font-family: 'Black';
        src: url('https://fonts.googleapis.com/css2?family=Outfit:wght@900&display=swap');
    }
    body { font-family: 'Inter', 'Cairo', sans-serif; }
</style>
@endsection
