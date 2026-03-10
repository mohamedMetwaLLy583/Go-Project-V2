<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تطبيق جو | Go App - رحلتك الأذكى والأسرع</title>

    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Tailwind CSS -->
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
                        primary: '#FF4C29', // لـون حيوي وجذاب
                        secondary: '#334756',
                        dark: '#082032',
                        accent: '#FACC15'
                    },
                    animation: {
                        'spin-slow': 'spin 15s linear infinite',
                        'bounce-slow': 'bounce 4s infinite',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Cairo', sans-serif; overflow-x: hidden; }
        
        .hero-pattern {
            background-color: #082032;
            background-image: radial-gradient(circle at 50% 50%, #334756 0%, #082032 60%);
        }

        /* 3D Animations */
        @keyframes float-3d {
            0% { transform: translateY(0px) rotateX(15deg) rotateY(-15deg); filter: drop-shadow(0 20px 30px rgba(0,0,0,0.4)); }
            50% { transform: translateY(-30px) rotateX(20deg) rotateY(-5deg); filter: drop-shadow(0 40px 40px rgba(0,0,0,0.6)); }
            100% { transform: translateY(0px) rotateX(15deg) rotateY(-15deg); filter: drop-shadow(0 20px 30px rgba(0,0,0,0.4)); }
        }
        
        @keyframes float-3d-reverse {
            0% { transform: translateY(0px) rotateX(10deg) rotateY(15deg) translateZ(-50px); }
            50% { transform: translateY(-20px) rotateX(15deg) rotateY(20deg) translateZ(0px); }
            100% { transform: translateY(0px) rotateX(10deg) rotateY(15deg) translateZ(-50px); }
        }

        .animate-float-3d {
            animation: float-3d 6s ease-in-out infinite;
            transform-style: preserve-3d;
        }

        .animate-float-3d-reverse {
            animation: float-3d-reverse 7s ease-in-out infinite;
            transform-style: preserve-3d;
        }

        .perspective-container {
            perspective: 2000px;
        }

        /* Glassmorphism */
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        /* 3D Hover Features */
        .feature-card {
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform-style: preserve-3d;
        }
        
        .feature-card:hover {
            transform: translateY(-15px) rotateX(10deg) rotateY(-5deg) scale(1.05);
            box-shadow: 20px 30px 50px rgba(0,0,0,0.15);
        }

        .feature-icon-wrapper {
            transition: transform 0.5s;
        }

        .feature-card:hover .feature-icon-wrapper {
            transform: translateZ(50px) translateY(-10px);
        }
    </style>
</head>
<body class="bg-gray-50 antialiased text-gray-800">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 backdrop-blur-xl glass-card border-b border-white/5" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2 group cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-orange-400 rounded-xl flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-primary/40 transform transition-transform group-hover:scale-110 group-hover:rotate-12">
                        GO
                    </div>
                    <span class="text-white font-black text-2xl tracking-wider">تطبيق جــو</span>
                </div>
                <div class="hidden md:flex items-center space-x-reverse space-x-8">
                    <a href="#features" class="text-gray-300 hover:text-primary transition-colors font-bold text-lg">مميزاتنا</a>
                    <a href="#app-preview" class="text-gray-300 hover:text-primary transition-colors font-bold text-lg">التطبيق</a>
                    <a href="#order-ride" class="text-gray-300 hover:text-primary transition-colors font-bold text-lg">اطلب مشوارك</a>
                    <a href="/admin" class="bg-white text-dark hover:bg-primary hover:text-white px-6 py-2.5 rounded-full transition-all font-black shadow-[0_0_15px_rgba(255,255,255,0.2)] hover:shadow-[0_0_20px_rgba(255,76,41,0.5)] transform hover:-translate-y-1">لوحة التحكم</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section (3D Elements) -->
    <div class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden hero-pattern perspective-container min-h-screen flex items-center">
        <!-- Floating Background Elements -->
        <div class="absolute top-1/4 right-1/4 w-32 h-32 bg-primary/20 rounded-full blur-2xl animate-spin-slow"></div>
        <div class="absolute bottom-1/4 left-1/4 w-40 h-40 bg-blue-500/20 rounded-full blur-2xl animate-bounce-slow"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Text Content -->
                <div data-aos="fade-left" class="text-center lg:text-right">
                    <div class="inline-block px-4 py-2 border border-primary/30 rounded-full bg-primary/10 text-primary font-bold mb-6 backdrop-blur-sm">
                        ✨ الإصدار الجديد متوفر الآن
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black text-white leading-tight mb-6 drop-shadow-xl">
                        وجهتك القادمة بلمسة <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-orange-300">سحرية</span>
                    </h1>
                    <p class="text-xl text-gray-300 mb-10 leading-relaxed font-semibold">
                        رحلات يومية، توصيل مدارس، وسفر بين المدن بأمان وتوفير حقيقي. اكتشف بُعداً جديداً في التنقل مع تطبيق جو.
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                        <a href="#order-ride" class="bg-gradient-to-r from-primary to-orange-500 text-white font-black text-lg py-4 px-8 rounded-full shadow-[0_10px_30px_rgba(255,76,41,0.4)] transition-all transform hover:-translate-y-2 hover:shadow-[0_15px_40px_rgba(255,76,41,0.6)] flex items-center gap-2">
                            🚕 احجز رحلة الآن
                        </a>
                        <a href="#download" class="glass-card text-white hover:bg-white/10 font-bold text-lg py-4 px-8 rounded-full transition-all transform hover:-translate-y-2 flex items-center gap-2 border border-white/20">
                            📱 حمل التطبيق
                        </a>
                    </div>
                </div>

                <!-- 3D Isometric App Mockup -->
                <div class="relative h-[600px] hidden lg:block" data-aos="fade-right" data-aos-delay="200">
                    <!-- Base glow -->
                    <div class="absolute inset-0 bg-primary/30 blur-[100px] rounded-full"></div>
                    
                    <!-- 3D Floating Phone 1 (Foreground) -->
                    <div class="absolute top-10 right-10 w-64 h-[500px] bg-gray-900 rounded-[2.5rem] border-8 border-gray-800 shadow-[20px_20px_60px_rgba(0,0,0,0.8)] overflow-hidden z-20 animate-float-3d">
                        <div class="absolute top-0 w-full h-full bg-gradient-to-br from-dark to-gray-800"></div>
                        <!-- Mockup Map -->
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iNDAwIj48cGF0aCBkPSJNMCAwbDQwMCA0MDBNMCA0MDBMNDAwIDAiIHN0cm9rZT0iIzMzNDc1NiIgc3Ryb2tlLXdpZHRoPSIxIi8+PHBhdGggZD0iMTAgMjAwaDQwME0yMDAgMHY0MDAiIHN0cm9rZT0iIzMzNDc1NiIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9zdmc+')] opacity-50"></div>
                        <div class="absolute top-4 left-1/2 -translate-x-1/2 w-20 h-6 bg-black rounded-b-xl z-30"></div>
                        
                        <!-- 3D App UI Elements inside Phone -->
                        <div class="absolute bottom-6 inset-x-4 bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 shadow-xl transform translate-z-10">
                            <div class="h-3 w-1/2 bg-white/40 rounded-full mb-3"></div>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary to-orange-500 rounded-full shadow-lg shadow-primary/50 flex items-center justify-center text-xl">🚗</div>
                                <div>
                                    <div class="h-2 w-20 bg-white/60 rounded-full mb-1"></div>
                                    <div class="h-2 w-12 bg-white/30 rounded-full"></div>
                                </div>
                            </div>
                            <div class="h-10 w-full bg-primary rounded-xl mt-2 flex items-center justify-center text-white text-xs font-bold">تأكيد</div>
                        </div>
                    </div>

                    <!-- 3D Floating Phone 2 (Background) -->
                    <div class="absolute top-20 left-0 w-56 h-[450px] bg-white rounded-[2rem] border-8 border-gray-100 shadow-[10px_20px_50px_rgba(0,0,0,0.5)] overflow-hidden z-10 animate-float-3d-reverse opacity-80">
                        <div class="absolute top-4 left-1/2 -translate-x-1/2 w-16 h-5 bg-black rounded-b-xl z-30"></div>
                        <div class="w-full h-40 bg-primary/10 rounded-b-3xl mb-4"></div>
                        <div class="px-4 space-y-3">
                            <div class="h-16 bg-gray-100 rounded-xl w-full"></div>
                            <div class="h-16 bg-gray-100 rounded-xl w-full"></div>
                            <div class="h-16 bg-gray-100 rounded-xl w-full"></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
        <!-- Bottom Curve -->
        <div class="absolute bottom-0 w-full overflow-hidden leading-none z-20">
            <svg class="relative block w-full h-12 md:h-24" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.08,130.83,123.15,189.2,109.91Z" class="fill-gray-50"></path>
            </svg>
        </div>
    </div>

    <!-- 3D Features Section -->
    <div id="features" class="py-24 bg-gray-50 relative overflow-hidden perspective-container">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="text-center mb-20" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-black text-dark mb-4">تخيل التنقل بشكل <span class="text-primary">مختلف</span></h2>
                <div class="w-24 h-2 bg-gradient-to-r from-primary to-orange-400 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Feature 1 -->
                <div class="feature-card bg-white rounded-[2rem] p-8 shadow-xl border border-gray-100 relative group" data-aos="zoom-in" data-aos-delay="100">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -z-10 group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="feature-icon-wrapper w-20 h-20 bg-gradient-to-br from-dark to-gray-800 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-dark/20 group-hover:bg-gradient-to-br group-hover:from-primary group-hover:to-orange-500">
                        <span class="text-4xl">🚀</span>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4 group-hover:text-primary transition-colors">سرعة تفوق التوقعات</h3>
                    <p class="text-gray-600 leading-relaxed font-semibold">بفضل نظام التوجيه الذكي، خوارزمياتنا تربطك بأقرب كابتن في أجزاء من الثانية. لا مزيد من الانتظار بالشارع.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-dark rounded-[2rem] p-8 shadow-2xl border border-gray-800 relative group md:-translate-y-8" data-aos="zoom-in" data-aos-delay="200">
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-primary/10 rounded-[2rem]"></div>
                    <div class="feature-icon-wrapper w-20 h-20 bg-gradient-to-br from-primary to-orange-500 rounded-2xl flex items-center justify-center mb-6 shadow-[0_0_30px_rgba(255,76,41,0.4)]">
                        <span class="text-4xl">🛡️</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">درع حماية متكامل</h3>
                    <p class="text-gray-300 leading-relaxed font-semibold">كافة الكباتن مسجلون رسمياً مع متابعة حية للرحلة عبر الـ GPS. نحن نضع سلامتك وسلامة عائلتك كأولوية قصوى.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-white rounded-[2rem] p-8 shadow-xl border border-gray-100 relative group" data-aos="zoom-in" data-aos-delay="300">
                    <div class="feature-icon-wrapper w-20 h-20 bg-gradient-to-br from-dark to-gray-800 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-dark/20 group-hover:bg-gradient-to-br group-hover:from-primary group-hover:to-orange-500">
                        <span class="text-4xl">💸</span>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4 group-hover:text-primary transition-colors">عروض وأسعار مذهلة</h3>
                    <p class="text-gray-600 leading-relaxed font-semibold">تسعيرة عادلة، ونظام محفظة ذكي يمنحك نقاط وهدايا عند الاستخدام. الدفع نقداً أو ببطاقتك بكل سهولة.</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-white rounded-[2rem] p-8 shadow-xl border border-gray-100 relative group" data-aos="zoom-in" data-aos-delay="400">
                    <div class="feature-icon-wrapper w-20 h-20 bg-gradient-to-br from-dark to-gray-800 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-dark/20 group-hover:bg-gradient-to-br group-hover:from-primary group-hover:to-orange-500">
                        <span class="text-4xl">🎒</span>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4 group-hover:text-primary transition-colors">رحلات المدارس الدورية</h3>
                    <p class="text-gray-600 leading-relaxed font-semibold">تعاقد شهري أو أسبوعي لتوصيل أبنائك. كابتن ثابت وموثوق لتوصيل المدارس في أوقات مجدولة وراحة بال تامة.</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-white rounded-[2rem] p-8 shadow-xl border border-gray-100 relative group md:-translate-y-8" data-aos="zoom-in" data-aos-delay="500">
                    <div class="feature-icon-wrapper w-20 h-20 bg-gradient-to-br from-dark to-gray-800 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-dark/20 group-hover:bg-gradient-to-br group-hover:from-primary group-hover:to-orange-500">
                        <span class="text-4xl">🌍</span>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4 group-hover:text-primary transition-colors">السفر بين المدن</h3>
                    <p class="text-gray-600 leading-relaxed font-semibold">رحلات طويلة بأسعار تنافسية بين كافة مناطق المملكة. سيارات حديثة مجهزة ومكيفة لضمان راحة الركاب بالكامل.</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-white rounded-[2rem] p-8 shadow-xl border border-gray-100 relative group" data-aos="zoom-in" data-aos-delay="600">
                    <div class="feature-icon-wrapper w-20 h-20 bg-gradient-to-br from-dark to-gray-800 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-dark/20 group-hover:bg-gradient-to-br group-hover:from-primary group-hover:to-orange-500">
                        <span class="text-4xl">👨‍💻</span>
                    </div>
                    <h3 class="text-2xl font-bold text-dark mb-4 group-hover:text-primary transition-colors">خدمة عملاء لحظية</h3>
                    <p class="text-gray-600 leading-relaxed font-semibold">فريقنا متواجد على مدار الـ 24 ساعة للتدخل وحل أي مشكلة قد تظهر لك، نضع راحتك في المقام الأول.</p>
                </div>

            </div>
        </div>
    </div>

    <!-- Interactive 3D Phone Showcase Section -->
    <div id="app-preview" class="py-24 bg-dark relative overflow-hidden perspective-container">
        <!-- Grid overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCI+PHBhdGggZD0iTTAgMEw0MCAwTzQwIDQwTDAgNDBaIiBmaWxsPSJub25lIi8+PHBhdGggZD0iTTAgMEg0MFY0MEgwWiIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDUpIiBzdHJva2Utd2lkdGg9IjEiLz48L3N2Zz4=')] opacity-30"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-16">
                
                <!-- Left: 3D Animated Showcase -->
                <div class="w-full lg:w-1/2 h-[600px] relative" data-aos="fade-left">
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-primary/40 blur-[100px] rounded-full"></div>
                    
                    <!-- Center Phone -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[280px] h-[550px] bg-white rounded-[3rem] border-8 border-gray-200 shadow-[0_30px_60px_rgba(0,0,0,0.6)] z-30 animate-float-3d" style="animation-duration: 8s;">
                        <img src="https://images.unsplash.com/photo-1610465299993-e6675c9f9fac?auto=format&fit=crop&q=80&w=400&h=800" class="w-full h-full object-cover rounded-[2.5rem]" alt="App Mockup GPS">
                        <!-- Glass UI overlay on phone -->
                        <div class="absolute bottom-6 inset-x-4 bg-white/20 backdrop-blur-xl border border-white/40 p-4 rounded-2xl shadow-xl">
                            <h4 class="font-bold text-white text-lg drop-shadow-md">الكابتن وصل!</h4>
                            <p class="text-white/90 text-sm font-semibold">تويوتا كامري - 1234 ص س ع</p>
                        </div>
                    </div>

                    <!-- Left floating card -->
                    <div class="absolute top-20 left-4 lg:-left-10 w-48 bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 shadow-2xl z-40 transform -rotate-12 animate-float-3d-reverse" style="animation-duration: 6s; animation-delay: 1s;">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white text-xl shadow-lg shadow-green-500/50">💵</div>
                            <div>
                                <h4 class="text-white font-bold">الدفع تم</h4>
                                <p class="text-green-400 font-bold text-sm">35 ر.س</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right floating card -->
                    <div class="absolute bottom-32 right-0 lg:-right-8 w-56 bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 shadow-2xl z-40 transform rotate-6 animate-float-3d" style="animation-duration: 7s; animation-delay: 2s;">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center text-dark font-black text-xl shadow-lg shadow-yellow-400/50">★</div>
                            <div>
                                <h4 class="text-white font-bold text-sm">كابتن خلوق جداً</h4>
                                <p class="text-yellow-400 font-black text-xs">تقييم 5 نجوم من الركاب</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Content -->
                <div class="w-full lg:w-1/2 text-center lg:text-right" data-aos="fade-right">
                    <h2 class="text-4xl md:text-5xl font-black text-white mb-6">تجربة مستخدم <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-orange-400">تنبض بالحياة</span></h2>
                    <p class="text-xl text-gray-400 mb-8 leading-relaxed font-semibold">
                        صُمم تطبيق جو بأحدث تقنيات الـ Flutter العالمية ليعمل بانسيابية تامة على الآيفون والأندرويد. واجهات تتفاعل معك، نظام التتبع اللحظي 3D، وإشعارات تبقيك على علم بكل ما هو جديد.
                    </p>
                    <ul class="space-y-4 mb-10 text-right inline-block lg:block">
                        <li class="flex items-center gap-3 text-lg text-gray-300 font-bold">
                            <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center text-white text-sm">✓</div>
                            واجهة داكنة مريحة للعين (Dark Mode)
                        </li>
                        <li class="flex items-center gap-3 text-lg text-gray-300 font-bold">
                            <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center text-white text-sm">✓</div>
                            إشعارات منبثقة تفاعلية بالصوت
                        </li>
                        <li class="flex items-center gap-3 text-lg text-gray-300 font-bold">
                            <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center text-white text-sm">✓</div>
                            نظام محفظة (Wallet) وحسابات شفافة
                        </li>
                    </ul>
                    <a href="#download" class="inline-block bg-white text-dark hover:bg-gray-100 font-black text-lg py-4 px-10 rounded-full shadow-xl transition-all transform hover:scale-105">
                        جربه بنفسك الآن
                    </a>
                </div>

            </div>
        </div>
        
        <!-- Bottom Curve -->
        <div class="absolute bottom-0 w-full overflow-hidden leading-none z-20">
            <svg class="relative block w-full h-12 md:h-24" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.08,130.83,123.15,189.2,109.91Z" class="fill-white"></path>
            </svg>
        </div>
    </div>

    <!-- Quick Web Order Form -->
    <div id="order-ride" class="py-24 bg-white relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" data-aos="fade-up">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-5xl font-black text-dark mb-4">اطلب <span class="text-primary">مشوارك المنقذ</span> الآن</h2>
                <p class="text-xl text-gray-500 font-bold">لا تملك التطبيق بعد؟ لا مشكلة! سجل بياناتك كطلب سريع وسنفزع لك.</p>
            </div>

            @if(session('success_ride'))
            <div class="mb-8 p-4 bg-green-100 border border-green-500 text-green-800 rounded-xl text-center font-bold shadow-md">
                {{ session('success_ride') }}
            </div>
            @endif

            <div class="bg-gray-50 rounded-[2rem] p-8 md:p-12 border border-gray-200 shadow-[0_20px_50px_rgba(0,0,0,0.1)] relative overflow-hidden transform-gpu">
                <div class="absolute -top-20 -right-20 w-40 h-40 bg-primary/20 rounded-full blur-3xl"></div>
                
                <form action="{{ route('ride.request.submit') }}" method="POST" class="space-y-6 relative z-10">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="ride_name" class="block text-sm font-bold text-gray-700 mb-2">اسمك الكريم</label>
                            <input type="text" id="ride_name" name="name" required class="w-full px-5 py-4 bg-white border border-gray-200 rounded-xl text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-sm font-semibold">
                        </div>
                        <div>
                            <label for="ride_phone" class="block text-sm font-bold text-gray-700 mb-2">رقم الجوال للتواصل</label>
                            <input type="tel" id="ride_phone" name="phone" placeholder="05xxxxxxxxx" required dir="ltr" class="w-full px-5 py-4 bg-white border border-gray-200 rounded-xl text-dark placeholder-gray-400 text-right focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-sm font-semibold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="pickup_location" class="block text-sm font-bold text-gray-700 mb-2">نقطة الانطلاق</label>
                            <input type="text" id="pickup_location" name="pickup_location" placeholder="الرياض، حي الملقا" required class="w-full px-5 py-4 bg-white border border-gray-200 rounded-xl text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-sm font-semibold">
                        </div>
                        <div>
                            <label for="dropoff_location" class="block text-sm font-bold text-gray-700 mb-2">جهة الوصول</label>
                            <input type="text" id="dropoff_location" name="dropoff_location" placeholder="المطار" required class="w-full px-5 py-4 bg-white border border-gray-200 rounded-xl text-dark placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-sm font-semibold">
                        </div>
                    </div>

                    <div class="pt-6 text-center">
                        <button type="submit" class="bg-dark hover:bg-gray-900 text-white font-black text-lg py-4 px-12 rounded-full w-full sm:w-auto shadow-2xl transition-all transform hover:scale-105 hover:-translate-y-1">
                            🚀 أرسل الطلب العاجل
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Call to Action (Download) -->
    <div id="download" class="bg-gray-100 py-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="zoom-in-up">
            <div class="bg-gradient-to-r from-dark to-slate-800 rounded-[3rem] p-10 md:p-16 flex flex-col md:flex-row items-center justify-between shadow-[0_20px_60px_rgba(8,32,50,0.5)] relative overflow-hidden">
                <!-- Abstract decorations -->
                <div class="absolute -right-20 -top-20 w-80 h-80 bg-primary/40 rounded-full blur-[80px]"></div>
                
                <div class="md:w-1/2 text-center md:text-right mb-10 md:mb-0 relative z-10">
                    <h2 class="text-4xl md:text-5xl font-black text-white mb-6">جاهز للإنطلاق؟</h2>
                    <p class="text-xl text-gray-300 mb-8 font-semibold">حمل تطبيق جو الآن، وانضم لآلاف المستخدمين والكباتن الذين يثقون بنا يومياً لبدء رحلتك.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <!-- Play Store -->
                        <a href="#" class="flex items-center justify-center gap-3 bg-white text-dark px-8 py-4 rounded-2xl hover:bg-gray-100 transition-colors font-bold text-lg shadow-xl hover:-translate-y-1 transform">
                            <svg class="w-8 h-8 text-green-500" viewBox="0 0 24 24" fill="currentColor"><path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.5,12.92 20.16,13.19L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/></svg>
                            <div class="text-right">
                                <div class="text-xs text-gray-500 font-bold">احصل عليه من</div>
                                <div>Google Play</div>
                            </div>
                        </a>
                        <!-- App Store -->
                        <a href="#" class="flex items-center justify-center gap-3 bg-white text-dark px-8 py-4 rounded-2xl hover:bg-gray-100 transition-colors font-bold text-lg shadow-xl hover:-translate-y-1 transform">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                            <div class="text-right">
                                <div class="text-xs text-gray-500 font-bold">تنزيل من</div>
                                <div>App Store</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-gray-300 py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center flex-col items-center gap-2 mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-primary to-orange-400 rounded-xl flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-primary/40 animate-bounce-slow">GO</div>
                <span class="text-white font-black text-2xl mt-2">تطبيق جــو</span>
                <p class="mt-2 font-semibold">تطبيق النقل الذكي الأول</p>
            </div>
            <div class="flex justify-center gap-8 mb-8 font-bold">
                <a href="#features" class="hover:text-primary transition-colors hover:-translate-y-1 transform">المميزات</a>
                <a href="/admin" class="hover:text-primary transition-colors hover:-translate-y-1 transform">الإدارة</a>
                <a href="#order-ride" class="hover:text-primary transition-colors hover:-translate-y-1 transform">تواصل معنا</a>
            </div>
            <p class="opacity-50 text-sm font-bold">شركة SDevelopment للتقنية والبرمجيات &copy; 2026. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <!-- Initialize AOS Animation Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 50,
            easing: 'ease-out-cubic'
        });

        // Navbar blur on scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 10) {
                document.getElementById('navbar').classList.add('shadow-xl', 'bg-dark/80');
                document.getElementById('navbar').classList.remove('border-white/5');
            } else {
                document.getElementById('navbar').classList.remove('shadow-xl', 'bg-dark/80');
                document.getElementById('navbar').classList.add('border-white/5');
            }
        });
    </script>
</body>
</html>
