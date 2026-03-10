<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') - Go Application</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');
        body {
            font-family: 'Cairo', sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0">
            <div class="p-6 border-b border-gray-800">
                <h1 class="text-2xl font-bold text-yellow-500">Go App</h1>
                <p class="text-xs text-gray-400 mt-1">لوحة إدارة النظام</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center py-3 px-6 hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 border-r-4 border-yellow-500' : '' }}">
                    <span class="ml-3">📊</span> الرئيسية
                </a>
                
                <a href="{{ route('admin.drivers.index') }}" 
                   class="flex items-center py-3 px-6 hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.drivers.*') ? 'bg-gray-800 border-r-4 border-yellow-500' : '' }}">
                    <span class="ml-3">🚗</span> السائقون
                </a>

                <a href="{{ route('admin.customers.index') }}" 
                   class="flex items-center py-3 px-6 hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-gray-800 border-r-4 border-yellow-500' : '' }}">
                    <span class="ml-3">👤</span> العملاء
                </a>
                
                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center py-3 px-6 hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 border-r-4 border-yellow-500' : '' }}">
                    <span class="ml-3">📦</span> الطلبات
                </a>
                
                <a href="{{ route('admin.tickets.index') }}" 
                   class="flex items-center py-3 px-6 hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.tickets.*') ? 'bg-gray-800 border-r-4 border-yellow-500' : '' }}">
                    <span class="ml-3">🎫</span> تذاكر الدعم
                </a>

                <a href="{{ route('admin.notifications.index') }}" 
                   class="flex items-center py-3 px-6 hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.notifications.*') ? 'bg-gray-800 border-r-4 border-yellow-500' : '' }}">
                    <span class="ml-3">🔔</span> الإشعارات
                </a>

                <a href="{{ route('admin.captain-requests.index') }}" 
                   class="flex items-center py-3 px-6 hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.captain-requests.*') ? 'bg-gray-800 border-r-4 border-yellow-500' : '' }}">
                    <span class="ml-3">📋</span> طلبات الكباتن
                </a>

                <a href="{{ route('admin.web-ride-requests.index') }}" 
                   class="flex items-center py-3 px-6 hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.web-ride-requests.*') ? 'bg-gray-800 border-r-4 border-yellow-500' : '' }}">
                    <span class="ml-3">🚕</span> المشاوير المباشرة
                </a>

                <div class="px-6 py-4 text-xs font-black text-gray-500 uppercase tracking-widest border-t border-gray-800 mt-4">إعدادات النظام</div>

                <a href="{{ route('admin.sliders.index') }}" 
                   class="flex items-center py-3 px-6 hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.sliders.*') ? 'bg-gray-800 border-r-4 border-yellow-500' : '' }}">
                    <span class="ml-3">🖼️</span> البانرات والعروض
                </a>

                <a href="{{ route('admin.nationalities.index') }}" 
                   class="flex items-center py-3 px-6 hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.nationalities.*') ? 'bg-gray-800 border-r-4 border-yellow-500' : '' }}">
                    <span class="ml-3">🌍</span> الجنسيات
                </a>

                <a href="{{ route('admin.regions.index') }}" 
                   class="flex items-center py-3 px-6 hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.regions.*') ? 'bg-gray-800 border-r-4 border-yellow-500' : '' }}">
                    <span class="ml-3">📍</span> المناطق والأحياء
                </a>

                <a href="{{ route('admin.roles.index') }}" 
                   class="flex items-center py-3 px-6 hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.roles.*') ? 'bg-gray-800 border-r-4 border-yellow-500' : '' }}">
                    <span class="ml-3">🛡️</span> الأدوار والصلاحيات
                </a>

                <a href="{{ route('admin.staff.index') }}" 
                   class="flex items-center py-3 px-6 hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.staff.*') ? 'bg-gray-800 border-r-4 border-yellow-500' : '' }}">
                    <span class="ml-3">👥</span> الموظفون (Admins)
                </a>
                
                <form method="POST" action="{{ route('admin.logout') }}" class="mt-10">
                    @csrf
                    <button type="submit" class="flex items-center w-full text-right py-3 px-6 hover:bg-red-900 text-red-400 transition-colors">
                        <span class="ml-3">🚪</span> تسجيل الخروج
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b">
                <div class="px-8 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">@yield('page-title', 'لوحة التحكم')</h2>
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <span class="text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                            {{ auth()->user()->name }} (مدير)
                        </span>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="mx-8 mt-6 p-4 bg-green-50 border-r-4 border-green-500 text-green-700 rounded shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mx-8 mt-6 p-4 bg-red-50 border-r-4 border-red-500 text-red-700 rounded shadow-sm">
                {{ session('error') }}
            </div>
            @endif

            <!-- Page Content -->
            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
