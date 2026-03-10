<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تطبيق جو | Go App - رحلتك الأذكى والأسرع</title>

    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN for quick integration) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Configuration & Custom Styles -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Cairo', 'sans-serif'],
                    },
                    colors: {
                        primary: '#FF4C29', // لـون حيوي وجذاب مثل البرتقالي الناري
                        secondary: '#334756',
                        dark: '#082032',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Cairo', sans-serif; }
        .hero-pattern {
            background-color: #082032;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23334756' fill-opacity='0.2'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-gray-50 antialiased text-gray-800">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 backdrop-blur-md bg-dark/90 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <!-- Logo Placeholder -->
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-primary/50">
                        GO
                    </div>
                    <span class="text-white font-bold text-2xl tracking-wider">تطبيق جــو</span>
                </div>
                <div class="hidden md:flex items-center space-x-reverse space-x-8">
                    <a href="#" class="text-gray-300 hover:text-white transition-colors font-semibold text-lg">الرئيسية</a>
                    <a href="#features" class="text-gray-300 hover:text-white transition-colors font-semibold text-lg">المميزات</a>
                    <a href="#download" class="text-gray-300 hover:text-white transition-colors font-semibold text-lg">حمل التطبيق</a>
                    <a href="/admin" class="bg-white/10 hover:bg-white/20 text-white px-5 py-2 rounded-full transition-all border border-white/20 font-bold backdrop-blur-sm">لوحة التحكم</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-pattern">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white z-10">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 drop-shadow-lg">
                مشوارك أسهل مع <span class="text-primary">جــو</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl md:text-2xl text-gray-300 mb-10 leading-relaxed">
                اطلب سيارتك الآن بضغطة زر. أسرع كباتن، أسعار في متناول اليد، وأمان تام لجميع رحلاتك.
            </p>
            <div class="flex justify-center gap-4 flex-col sm:flex-row">
                <a href="#download" class="bg-primary hover:bg-orange-600 text-white font-bold text-lg py-4 px-10 rounded-full shadow-[0_0_30px_rgba(255,76,41,0.5)] transition-all transform hover:scale-105">
                    احمل التطبيق للركاب
                </a>
                <a href="#join-captain" class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white font-bold text-lg py-4 px-10 rounded-full transition-all transform hover:scale-105">
                    سجل كـ كابتن (سائق)
                </a>
            </div>
        </div>
        
        <!-- Decorative blob -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>
    </div>

    <!-- Features Section -->
    <div id="features" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-dark mb-4">لماذا تختار تطبيق جو؟</h2>
                <div class="w-24 h-1.5 bg-primary mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Feature 1 -->
                <div class="bg-gray-50 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-100 group text-center hover:-translate-y-2">
                    <div class="w-20 h-20 mx-auto bg-dark rounded-2xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4">سرعة في الوصول</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">بمجرد طلبك للرحلة، يقوم نظامنا الذكي بتوجيه أقرب كابتن متاح إليك فوراً دون تأخير.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-100 group text-center hover:-translate-y-2 relative -top-0 md:-top-4">
                    <div class="w-20 h-20 mx-auto bg-primary rounded-2xl flex items-center justify-center mb-6 shadow-xl shadow-primary/40">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4">أمان وموثوقية</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">جميع الكباتن مسجلون رسمياً ومعتمدون. رحلتك مراقبة لتوفير أعلى معايير السلامة لك ولعائلتك.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-100 group text-center hover:-translate-y-2">
                    <div class="w-20 h-20 mx-auto bg-dark rounded-2xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4">أسعار تنافسية</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">نقدم أفضل الأسعار للرحلات مع عروض مستمرة ونظام مكافآت يضمن لك التوفير في كل مشوار.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gray-50 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-100 group text-center hover:-translate-y-2">
                    <div class="w-20 h-20 mx-auto bg-dark rounded-2xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4">خيارات دفع مرنة</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">ادفع بالطريقة التي تناسبك: نقداً، بالبطاقة الائتمانية، أو عبر المحفظة الإلكترونية داخل التطبيق بسهولة تامة.</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gray-50 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-100 group text-center hover:-translate-y-2 relative -top-0 md:-top-4">
                    <div class="w-20 h-20 mx-auto bg-primary rounded-2xl flex items-center justify-center mb-6 shadow-xl shadow-primary/40">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4">تقييم مستمر للجودة</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">نظام تقييم متبادل بعد كل رحلة يضمن بقاء أفضل الكباتن فقط في الخدمة للحفاظ على راحتك ورضاك.</p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gray-50 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300 border border-gray-100 group text-center hover:-translate-y-2">
                    <div class="w-20 h-20 mx-auto bg-dark rounded-2xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4">دعم فني 24/7</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">فريق خدمة العملاء متواجد على مدار الساعة وجاهز للرد على استفساراتك وحل أي مشكلة قد تواجهك فوراً.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- App Screenshots/Mockups Section -->
    <div id="app-preview" class="py-24 bg-gray-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-dark mb-4">نظرة على التطبيق</h2>
                <div class="w-24 h-1.5 bg-primary mx-auto rounded-full mb-6"></div>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">تصميم عصري وسهل الاستخدام يتيح لك طلب رحلتك وتتبعها في ثوانٍ معدودة.</p>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-center gap-8 lg:gap-16">
                <!-- Screen 1 -->
                <div class="relative group transform transition-all duration-500 hover:-translate-y-4">
                    <div class="absolute inset-0 bg-primary/20 rounded-[3rem] blur-xl transform group-hover:scale-105 transition-transform duration-500"></div>
                    <div class="w-64 h-[500px] bg-white rounded-[3rem] border-[10px] border-dark shadow-2xl overflow-hidden relative z-10">
                        <div class="absolute top-0 inset-x-0 h-6 bg-dark rounded-b-3xl"></div>
                        <!-- Mockup Content: Map View -->
                        <div class="w-full h-full bg-gray-200 relative">
                            <!-- Fake Map Graphic -->
                            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iNDAwIj48cGF0aCBkPSJNMCAwbDQwMCA0MDBNMCA0MDBMNDAwIDAiIHN0cm9rZT0iI0RGRDdEMyIgc3Ryb2tlLXdpZHRoPSIyIi8+PHBhdGggZD0iTTAgMjAwaDQwME0yMDAgMHY0MDAiIHN0cm9rZT0iI0RGRDdEMyIgc3Ryb2tlLXdpZHRoPSIyIi8+PC9zdmc+')] bg-cover opacity-50"></div>
                            
                            <!-- Fake Route -->
                            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                <path d="M 20,80 Q 50,50 80,20" fill="none" class="stroke-primary" stroke-width="3" stroke-dasharray="5,5"/>
                                <circle cx="20" cy="80" r="4" class="fill-blue-500"/>
                                <circle cx="80" cy="20" r="4" class="fill-red-500"/>
                            </svg>

                            <!-- Fake Bottom Sheet -->
                            <div class="absolute bottom-0 inset-x-0 bg-white rounded-t-3xl shadow-[0_-5px_15px_rgba(0,0,0,0.1)] p-5">
                                <div class="w-12 h-1.5 bg-gray-300 rounded-full mx-auto mb-4"></div>
                                <h4 class="font-bold text-lg mb-2 text-dark">تأكيد نقطة الانطلاق</h4>
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl mb-4 border border-gray-100">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                    <span class="text-sm font-semibold text-gray-700">الرياض، حي الملقا</span>
                                </div>
                                <button class="w-full bg-primary text-white py-3 rounded-xl font-bold">تأكيد الموقع</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Screen 2 (Central & Prominent) -->
                <div class="relative group transform transition-all duration-500 hover:-translate-y-4 md:-translate-y-8 z-20">
                    <div class="absolute inset-0 bg-orange-500/30 rounded-[3rem] blur-2xl transform group-hover:scale-105 transition-transform duration-500"></div>
                    <div class="w-72 h-[560px] bg-white rounded-[3rem] border-[10px] border-dark shadow-2xl overflow-hidden relative z-10">
                        <div class="absolute top-0 inset-x-0 h-6 bg-dark rounded-b-3xl"></div>
                        <!-- Mockup Content: Searching/Driver Found -->
                        <div class="w-full h-full bg-primary/10 relative flex flex-col justify-between p-5 pt-10">
                            
                            <div class="text-center mt-4">
                                <h3 class="font-black text-2xl text-dark mb-1">2 دقائق</h3>
                                <p class="text-sm font-semibold text-primary">الكابتن في الطريق إليك</p>
                            </div>

                            <!-- Fake Car -->
                            <div class="flex justify-center my-6">
                                <div class="w-32 h-16 bg-white shadow-lg rounded-2xl flex items-center justify-center border-2 border-primary/20 relative">
                                    <span class="font-black text-dark text-xl">🚗 GO</span>
                                    <!-- Signal pulse -->
                                    <div class="absolute -inset-4 border-2 border-primary rounded-3xl animate-ping opacity-20"></div>
                                </div>
                            </div>
                            
                            <!-- Driver Card -->
                            <div class="bg-white p-4 rounded-2xl shadow-lg border border-gray-100 mt-auto mb-2">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-500">م</div>
                                    <div>
                                        <h4 class="font-bold text-dark text-sm">محمد أحمد</h4>
                                        <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                            <span class="text-yellow-400">★</span> 4.9 (120 رحلة)
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center text-xs font-bold text-gray-600 border-t pt-3">
                                    <span>تويوتا كامري</span>
                                    <span>أ ب ج 1234</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Screen 3 -->
                <div class="relative group transform transition-all duration-500 hover:-translate-y-4">
                    <div class="absolute inset-0 bg-primary/20 rounded-[3rem] blur-xl transform group-hover:scale-105 transition-transform duration-500"></div>
                    <div class="w-64 h-[500px] bg-white rounded-[3rem] border-[10px] border-dark shadow-2xl overflow-hidden relative z-10">
                        <div class="absolute top-0 inset-x-0 h-6 bg-dark rounded-b-3xl"></div>
                        <!-- Mockup Content: Payment/Receipt -->
                        <div class="w-full h-full bg-gray-50 relative p-5 pt-12 flex flex-col">
                            
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 mt-4">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            
                            <h3 class="text-center font-bold text-xl text-dark mb-1">الرحلة اكتملت!</h3>
                            <p class="text-center text-gray-500 text-xs mb-6">نتمنى لك يوماً سعيداً</p>

                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-4">
                                <div class="flex justify-between items-center mb-3 text-sm">
                                    <span class="text-gray-500">المسافة</span>
                                    <span class="font-bold">12 كم</span>
                                </div>
                                <div class="flex justify-between items-center mb-3 text-sm">
                                    <span class="text-gray-500">الوقت</span>
                                    <span class="font-bold">25 دقيقة</span>
                                </div>
                                <div class="border-t pt-3 flex justify-between items-center">
                                    <span class="font-bold text-sm">الإجمالي</span>
                                    <span class="font-black text-lg text-primary">35 ر.س</span>
                                </div>
                            </div>

                            <button class="w-full bg-dark text-white py-3 rounded-xl font-bold mt-auto text-sm">تم تقييم الكابتن بـ 5 نجوم ★</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Become a Captain Section (Driver Registration Form) -->
    <div id="join-captain" class="py-24 bg-dark relative overflow-hidden">
        <!-- Abstract decorations -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary/20 rounded-full blur-[80px] translate-y-1/2 -translate-x-1/2"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-5xl font-bold text-white mb-4">انضم لفريق كباتن <span class="text-primary">جــو</span></h2>
                <p class="text-xl text-gray-400">سجل بياناتك الآن وسنتواصل معك لاستكمال إجراءات انضمامك والبدء في تحقيق الأرباح.</p>
            </div>

            @if(session('success_join'))
            <div class="mb-8 p-4 bg-green-500/20 border border-green-500 text-white rounded-xl text-center">
                {{ session('success_join') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-8 p-4 bg-red-500/20 border border-red-500 text-white rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 md:p-12 border border-white/10 shadow-2xl">
                <form action="{{ route('join.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">الاسم الثلاثي</label>
                            <input type="text" id="name" name="name" placeholder="أدخل اسمك الكامل" required class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">رقم الجوال</label>
                            <input type="tel" id="phone" name="phone" placeholder="مثال: 05xxxxxxxxx" required dir="ltr" class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 text-right focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-300 mb-2">المدينة</label>
                            <select id="city" name="city" required class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all appearance-none cursor-pointer">
                                <option value="" disabled selected class="text-gray-900">اختر مدينتك</option>
                                <option value="riyadh" class="text-gray-900">الرياض</option>
                                <option value="jeddah" class="text-gray-900">جدة</option>
                                <option value="dammam" class="text-gray-900">الدمام</option>
                                <option value="makkah" class="text-gray-900">مكة المكرمة</option>
                                <option value="other" class="text-gray-900">أخرى</option>
                            </select>
                        </div>
                        <div>
                            <label for="car_model" class="block text-sm font-medium text-gray-300 mb-2">موديل السيارة وسنة الصنع</label>
                            <input type="text" id="car_model" name="car_model" placeholder="مثال: تويوتا كامري 2022" required class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>
                    </div>

                    <p class="text-sm text-gray-400 text-center mt-4">بضغطك على زر التسجيل، أنت توافق على معالجة بياناتك بغرض التواصل معك.</p>

                    <div class="pt-4 text-center">
                        <button type="submit" class="bg-primary hover:bg-orange-600 text-white font-bold text-lg py-4 px-12 rounded-full w-full sm:w-auto shadow-[0_0_20px_rgba(255,76,41,0.4)] transition-all transform hover:scale-105">
                            سجل اهتمامك الآن
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Call to Action (Download) -->
    <div id="download" class="bg-gray-100 py-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-dark rounded-[3rem] p-10 md:p-16 flex flex-col md:flex-row items-center justify-between shadow-2xl relative overflow-hidden">
                <!-- Abstract decorations -->
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-primary/30 rounded-full blur-3xl"></div>
                <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl"></div>
                
                <div class="md:w-1/2 text-center md:text-right mb-10 md:mb-0 relative z-10">
                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">جاهز للإنطلاق؟</h2>
                    <p class="text-xl text-gray-300 mb-8">حمل التطبيق الآن وانضم لآلاف المستخدمين الذين يثقون بنا يومياً.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <!-- Play Store Button Placeholder -->
                        <a href="#" class="flex items-center justify-center gap-3 bg-white text-dark px-6 py-3 rounded-xl hover:bg-gray-100 transition-colors font-bold text-lg shadow-lg hover:scale-105 transform">
                            <svg class="w-8 h-8 text-green-500" viewBox="0 0 24 24" fill="currentColor"><path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.5,12.92 20.16,13.19L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/></svg>
                            <div class="text-right">
                                <div class="text-xs text-gray-500 font-normal">احصل عليه من</div>
                                <div>Google Play</div>
                            </div>
                        </a>
                        <!-- App Store Button Placeholder -->
                        <a href="#" class="flex items-center justify-center gap-3 bg-white text-dark px-6 py-3 rounded-xl hover:bg-gray-100 transition-colors font-bold text-lg shadow-lg hover:scale-105 transform">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                            <div class="text-right">
                                <div class="text-xs text-gray-500 font-normal">تنزيل من</div>
                                <div>App Store</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="md:w-1/3 relative z-10 hidden md:block">
                    <!-- Phone Mockup Graphic -->
                    <div class="w-64 h-[500px] bg-gray-900 rounded-[3rem] border-8 border-gray-800 shadow-2xl mx-auto overflow-hidden relative rotate-y-12 rotate-x-12 transform perspective-1000">
                        <div class="absolute top-0 w-full h-full bg-gradient-to-br from-primary to-orange-400 opacity-90"></div>
                        <div class="absolute top-4 left-1/2 -translate-x-1/2 w-20 h-6 bg-black rounded-b-xl z-20"></div>
                        <div class="absolute inset-0 flex items-center justify-center flex-col text-white p-6 text-center">
                            <h3 class="text-3xl font-black mb-2 shadow-sm">GO</h3>
                            <p class="font-bold">حدّد وجهتك<br>وانطلق!</p>
                            
                            <div class="mt-8 bg-white/20 w-full h-12 rounded-lg flex items-center px-4 backdrop-blur-sm">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                <div class="h-2 w-24 bg-white/50 rounded ml-2"></div>
                            </div>
                            <div class="mt-4 bg-white/20 w-full h-32 rounded-lg py-3 px-4 backdrop-blur-sm flex flex-col gap-3">
                                <div class="h-10 border-b border-white/20 flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                    <div class="h-2 w-20 bg-white/50 rounded ml-2"></div>
                                </div>
                                <div class="mt-4 w-full bg-white text-primary text-sm font-bold py-2 rounded-full text-center">
                                    تأكيد الرحلة
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-gray-300 py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center items-center gap-2 mb-6">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white font-bold text-xl">GO</div>
                <span class="text-white font-bold text-xl">تطبيق جــو</span>
            </div>
            <p class="mb-6 opacity-70">شركة SDevelopment للتقنية والبرمجيات &copy; 2026. جميع الحقوق محفوظة.</p>
            <div class="flex justify-center gap-6">
                <a href="#" class="hover:text-primary transition-colors">حولنا</a>
                <a href="#" class="hover:text-primary transition-colors">الشروط والأحكام</a>
                <a href="#" class="hover:text-primary transition-colors">سياسة الخصوصية</a>
                <a href="#" class="hover:text-primary transition-colors">اتصل بنا</a>
            </div>
        </div>
    </footer>

</body>
</html>
