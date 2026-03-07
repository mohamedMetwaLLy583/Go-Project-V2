@extends('admin.layouts.app')

@section('title', 'إضافة طلب جديد')
@section('page-title', 'إضافة طلب جديد')

@section('content')
<div class="max-w-5xl mx-auto pb-12">
    <form action="{{ route('admin.orders.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Main Form Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Right Column: Settings & Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Info -->
                <div class="bg-white rounded-xl shadow-sm border p-8">
                    <h4 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4 flex items-center">
                        <span class="bg-yellow-100 text-yellow-700 w-8 h-8 rounded-full flex items-center justify-center ml-3 text-sm">1</span>
                        المعلومات الأساسية والعميل
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">العميل (صاحب الطلب)</label>
                            <select name="user_id" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none bg-gray-50" required>
                                <option value="">اختر العميل</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->phone }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">الجنسية المطلوبة للسائق</label>
                            <select name="nationality_id" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none bg-gray-50" required>
                                <option value="">اختر الجنسية</option>
                                @foreach($nationalities as $nationality)
                                    <option value="{{ $nationality->id }}">{{ $nationality->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">نوع الدوام</label>
                            <div class="flex space-x-4 space-x-reverse mt-2">
                                <label class="flex items-center">
                                    <input type="radio" name="shift_type" value="fixed" checked class="ml-2 text-yellow-500 focus:ring-yellow-500">
                                    <span class="text-sm">ثابت</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="shift_type" value="variable" class="ml-2 text-yellow-500 focus:ring-yellow-500">
                                    <span class="text-sm">متغير</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">نوع التوصيل</label>
                            <select name="trip_type" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none bg-gray-50">
                                <option value="round_trip">ذهاب وعودة</option>
                                <option value="go_only">ذهاب فقط</option>
                                <option value="return_only">عودة فقط</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Schedule & Preferences -->
                <div class="bg-white rounded-xl shadow-sm border p-8">
                    <h4 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4 flex items-center">
                        <span class="bg-blue-100 text-blue-700 w-8 h-8 rounded-full flex items-center justify-center ml-3 text-sm">2</span>
                        المواعيد والتفضيلات
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">أيام التوصيل</label>
                            <div class="grid grid-cols-2 gap-2 p-3 border rounded-lg bg-gray-50">
                                @foreach(['السبت', 'الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'] as $day)
                                <label class="flex items-center space-x-2 space-x-reverse">
                                    <input type="checkbox" name="delivery_days[]" value="{{ $day }}" class="rounded text-yellow-500">
                                    <span class="text-xs text-gray-600">{{ $day }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">أيام الإجازة</label>
                            <div class="grid grid-cols-2 gap-2 p-3 border rounded-lg bg-gray-50">
                                @foreach(['السبت', 'الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'] as $day)
                                <label class="flex items-center space-x-2 space-x-reverse">
                                    <input type="checkbox" name="vacation_days[]" value="{{ $day }}" class="rounded text-red-500">
                                    <span class="text-xs text-gray-600">{{ $day }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ بداية الدوام</label>
                            <input type="date" name="start_date" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 outline-none bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">حالة السيارة</label>
                            <div class="flex space-x-4 space-x-reverse mt-2">
                                <label class="flex items-center">
                                    <input type="radio" name="car_condition" value="standard" checked class="ml-2 text-yellow-500 focus:ring-yellow-500">
                                    <span class="text-sm">عادية</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="car_condition" value="new" class="ml-2 text-yellow-500 focus:ring-yellow-500">
                                    <span class="text-sm">حديثة</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                        <label class="flex items-center bg-gray-50 p-3 rounded-lg border cursor-pointer hover:bg-white transition-colors">
                            <input type="checkbox" name="needs_ac" value="1" checked class="w-5 h-5 text-blue-500 rounded ml-3">
                            <div>
                                <p class="text-sm font-bold">تكييف</p>
                                <p class="text-xs text-gray-500">يلزم وجود مكيف</p>
                            </div>
                        </label>
                        <label class="flex items-center bg-gray-50 p-3 rounded-lg border cursor-pointer hover:bg-white transition-colors">
                            <input type="checkbox" name="tinted_glass" value="1" class="w-5 h-5 text-gray-700 rounded ml-3">
                            <div>
                                <p class="text-sm font-bold">زجاج مظلل</p>
                                <p class="text-xs text-gray-500">يفضل زجاج عازل</p>
                            </div>
                        </label>
                        <label class="flex items-center bg-gray-50 p-3 rounded-lg border cursor-pointer hover:bg-white transition-colors">
                            <input type="checkbox" name="is_shared" value="1" class="w-5 h-5 text-green-500 rounded ml-3">
                            <div>
                                <p class="text-sm font-bold">رحلة مشتركة</p>
                                <p class="text-xs text-gray-500">يمكن وجود ركاب آخرين</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Passengers List -->
                <div class="bg-white rounded-xl shadow-sm border p-8">
                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                        <h4 class="text-xl font-bold text-gray-800 flex items-center">
                            <span class="bg-green-100 text-green-700 w-8 h-8 rounded-full flex items-center justify-center ml-3 text-sm">3</span>
                            بيانات الركاب ومخطط السير
                        </h4>
                        <button type="button" onclick="addPassenger()" class="bg-yellow-50 text-yellow-700 px-4 py-2 rounded-lg text-sm font-bold hover:bg-yellow-100 transition-colors border border-yellow-200">
                            + إضافة راكب جديد
                        </button>
                    </div>
                    
                    <div id="passengers-container" class="space-y-8">
                        <!-- Passenger Template -->
                        <div class="passenger-item p-6 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 relative group">
                            <div class="absolute -top-3 -right-3 bg-white px-3 py-1 rounded-full border shadow-sm font-bold text-gray-500 text-xs">راكب #1</div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1">اسم الراكب</label>
                                    <input type="text" name="passengers[0][name]" class="w-full border rounded-lg p-2 focus:border-yellow-500 outline-none" placeholder="الاسم الكامل" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 mb-1">فئة الراكب</label>
                                    <select name="passengers[0][type]" class="w-full border rounded-lg p-2 focus:border-yellow-500 outline-none" required>
                                        <option value="male">رجل</option>
                                        <option value="female">سيدة</option>
                                        <option value="child">طفل / طالب</option>
                                        <option value="elderly">كبير سن</option>
                                    </select>
                                </div>
                                
                                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-4 rounded-lg border">
                                    <!-- Pickup -->
                                    <div class="space-y-4">
                                        <p class="text-xs font-bold text-blue-600 border-b pb-1">نقطة الانطلاق</p>
                                        <div class="flex space-x-2 space-x-reverse mb-2">
                                            @foreach(['home' => 'البيت', 'work' => 'الدوام', 'school' => 'المدرسة'] as $val => $lbl)
                                            <label class="flex-1 text-center py-1 border rounded text-xs cursor-pointer hover:bg-blue-50">
                                                <input type="radio" name="passengers[0][pickup_location_type]" value="{{ $val }}" {{ $val == 'home' ? 'checked' : '' }} class="hidden">
                                                <span>{{ $lbl }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                        <input type="text" name="passengers[0][pickup_neighborhood]" class="w-full border rounded p-2 text-sm" placeholder="الحي">
                                        <input type="text" name="passengers[0][pickup_location]" class="w-full border rounded p-2 text-sm" placeholder="رابط الخريطة أو وصف الموقع">
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="time" name="passengers[0][driver_arrival_time]" class="border rounded p-2 text-xs" title="موعد حضور السائق">
                                            <input type="time" name="passengers[0][work_start_time]" class="border rounded p-2 text-xs" title="موعد بداية الدوام">
                                        </div>
                                    </div>
                                    <!-- Return -->
                                    <div class="space-y-4">
                                        <p class="text-xs font-bold text-red-600 border-b pb-1">نقطة العودة</p>
                                        <div class="flex space-x-2 space-x-reverse mb-2">
                                            @foreach(['home' => 'البيت', 'work' => 'الدوام', 'school' => 'المدرسة'] as $val => $lbl)
                                            <label class="flex-1 text-center py-1 border rounded text-xs cursor-pointer hover:bg-red-50">
                                                <input type="radio" name="passengers[0][return_location_type]" value="{{ $val }}" {{ $val == 'work' ? 'checked' : '' }} class="hidden">
                                                <span>{{ $lbl }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                        <input type="text" name="passengers[0][return_neighborhood]" class="w-full border rounded p-2 text-sm" placeholder="الحي">
                                        <input type="text" name="passengers[0][return_location]" class="w-full border rounded p-2 text-sm" placeholder="رابط الخريطة أو وصف الموقع">
                                        <div class="grid grid-cols-1">
                                            <input type="time" name="passengers[0][return_time]" class="border rounded p-2 text-xs" title="موعد الخروج">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Left Column: Pricing & Meta -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Count Card -->
                <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 p-8 text-white">
                    <h4 class="text-lg font-bold mb-6 border-b border-gray-700 pb-4">تعداد الركاب</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">رجال</span>
                            <input type="number" name="men_count" value="0" min="0" class="w-16 bg-gray-700 border-none rounded p-1 text-center text-yellow-400 font-bold">
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">سيدات</span>
                            <input type="number" name="women_count" value="0" min="0" class="w-16 bg-gray-700 border-none rounded p-1 text-center text-yellow-400 font-bold">
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">طلاب (بنين)</span>
                            <input type="number" name="student_m_count" value="0" min="0" class="w-16 bg-gray-700 border-none rounded p-1 text-center text-yellow-400 font-bold">
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm">طالبات (بنات)</span>
                            <input type="number" name="student_f_count" value="0" min="0" class="w-16 bg-gray-700 border-none rounded p-1 text-center text-yellow-400 font-bold">
                        </div>
                    </div>
                </div>

                <!-- Pricing Card -->
                <div class="bg-white rounded-xl shadow-sm border p-8">
                    <h4 class="text-lg font-bold text-gray-800 mb-6 border-b pb-4">البيانات المالية</h4>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wide">المسافة التقريبية (كم)</label>
                            <div class="relative">
                                <input type="number" name="distance_km" class="w-full border rounded-lg p-3 pr-12 font-bold text-gray-700" placeholder="0">
                                <span class="absolute left-4 top-3 text-gray-400">كم</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wide">الراتب / السعر (شهري)</label>
                            <div class="relative">
                                <input type="number" name="salary" class="w-full border-2 border-yellow-500 rounded-lg p-3 pr-12 font-extrabold text-2xl text-yellow-600 bg-yellow-50" placeholder="500">
                                <span class="absolute left-4 top-4 text-gray-500">SR</span>
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2 italic">* السعر الذي يدفعه العميل شهرياً</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wide">سعر الرحلة الواحدة (للسائق)</label>
                            <input type="number" name="price" class="w-full border rounded-lg p-2 text-gray-600" placeholder="السعر المقترح للسائق">
                        </div>
                    </div>
                </div>

                <!-- Status & Urgency -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-bold text-gray-700">طلب عاجل؟</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_urgent" value="1" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-500"></div>
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-yellow-500 text-white font-black py-4 rounded-xl shadow-lg hover:bg-yellow-600 transition-all transform hover:-translate-y-1 active:scale-95 mb-4">
                        نشر الطلب الآن 🚀
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="block w-full text-center text-sm font-bold text-gray-400 hover:text-gray-600 underline">إلغاء والعودة</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let passengerCount = 1;

    function addPassenger() {
        const container = document.getElementById('passengers-container');
        const div = document.createElement('div');
        div.className = 'passenger-item p-6 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 relative group animate-fade-in';
        
        div.innerHTML = `
            <button type="button" onclick="this.parentElement.remove()" class="absolute -top-3 -left-3 bg-red-500 text-white w-7 h-7 rounded-full flex items-center justify-center shadow-lg hover:bg-red-600 z-10">×</button>
            <div class="absolute -top-3 -right-3 bg-white px-3 py-1 rounded-full border shadow-sm font-bold text-gray-500 text-xs">راكب #${passengerCount + 1}</div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">اسم الراكب</label>
                    <input type="text" name="passengers[${passengerCount}][name]" class="w-full border rounded-lg p-2 focus:border-yellow-500 outline-none" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">فئة الراكب</label>
                    <select name="passengers[${passengerCount}][type]" class="w-full border rounded-lg p-2 focus:border-yellow-500 outline-none" required>
                        <option value="male">رجل</option>
                        <option value="female">سيدة</option>
                        <option value="child">طفل / طالب</option>
                        <option value="elderly">كبير سن</option>
                    </select>
                </div>
                
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 bg-white p-4 rounded-lg border">
                    <div class="space-y-4">
                        <p class="text-xs font-bold text-blue-600 border-b pb-1">نقطة الانطلاق</p>
                        <div class="flex space-x-2 space-x-reverse mb-2">
                             <input type="radio" name="passengers[${passengerCount}][pickup_location_type]" value="home" checked> البيت
                             <input type="radio" name="passengers[${passengerCount}][pickup_location_type]" value="work"> الدوام
                             <input type="radio" name="passengers[${passengerCount}][pickup_location_type]" value="school"> المدرسة
                        </div>
                        <input type="text" name="passengers[${passengerCount}][pickup_neighborhood]" class="w-full border rounded p-2 text-sm" placeholder="الحي">
                        <input type="text" name="passengers[${passengerCount}][pickup_location]" class="w-full border rounded p-2 text-sm" placeholder="رابط الخريطة">
                        <div class="grid grid-cols-2 gap-2">
                            <input type="time" name="passengers[${passengerCount}][driver_arrival_time]" class="border rounded p-2 text-xs">
                            <input type="time" name="passengers[${passengerCount}][work_start_time]" class="border rounded p-2 text-xs">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <p class="text-xs font-bold text-red-600 border-b pb-1">نقطة العودة</p>
                        <div class="flex space-x-2 space-x-reverse mb-2">
                             <input type="radio" name="passengers[${passengerCount}][return_location_type]" value="home"> البيت
                             <input type="radio" name="passengers[${passengerCount}][return_location_type]" value="work" checked> الدوام
                             <input type="radio" name="passengers[${passengerCount}][return_location_type]" value="school"> المدرسة
                        </div>
                        <input type="text" name="passengers[${passengerCount}][return_neighborhood]" class="w-full border rounded p-2 text-sm" placeholder="الحي">
                        <input type="text" name="passengers[${passengerCount}][return_location]" class="w-full border rounded p-2 text-sm" placeholder="رابط الخريطة">
                        <div class="grid grid-cols-1">
                            <input type="time" name="passengers[${passengerCount}][return_time]" class="border rounded p-2 text-xs">
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        container.appendChild(div);
        passengerCount++;
    }
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 0.4s ease-out forwards; }
</style>
@endsection
