<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول المشرفين - Go App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md border">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Go Application</h1>
            <p class="text-gray-500 mt-2">تسجيل دخول المشرفين</p>
        </div>

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all">
            </div>

            <div class="mb-8">
                <label class="block text-gray-700 text-sm font-bold mb-2">كلمة المرور</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all">
            </div>

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 text-red-600 rounded-lg text-sm font-bold">
                {{ $errors->first() }}
            </div>
            @endif

            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 rounded-lg transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                دخول النظام
            </button>
        </form>

        <div class="mt-8 text-center text-gray-400 text-sm">
            &copy; 2026 جميع الحقوق محفوظة
        </div>
    </div>
</body>
</html>
