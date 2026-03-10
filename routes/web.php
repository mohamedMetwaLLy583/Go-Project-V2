<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDriverController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminTicketController;
use App\Http\Controllers\Admin\AdminNationalityController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminStaffController;
use App\Http\Controllers\Admin\AdminRegionController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminCaptainJoinRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/join-captain', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'city' => 'required|string|max:100',
        'car_model' => 'required|string|max:255',
    ]);
    \App\Models\CaptainJoinRequest::create($request->all());
    return redirect()->to('/#join-captain')->with('success_join', 'تم تسجيل طلبك بنجاح! سيتواصل معك فريق الدعم قريباً لاستكمال أوراقك.');
})->name('join.submit');

Route::get('/db-test', function () {
    try {
        $pwd = env('DB_PASSWORD');
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        return "Connected successfully. Parsed password length: " . strlen($pwd);
    } catch (\Exception $e) {
        $pwd = env('DB_PASSWORD');
        return "Could not connect to the database. Error: " . $e->getMessage() . " | Parsed DB_PASSWORD length: " . strlen((string)$pwd) . " | Expected length: 16";
    }
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Guest Admin
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    // Magic Upgrade Route - النسخة النهائية المضمونة
    Route::get('/magic-upgrade', function () {
        try {
            // 1. تنظيف شامل لملفات الكاش والإعدادات
            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            
            // 2. إعادة بناء قاعدة البيانات بالكامل (تمسح كل شيء وتبدأ من جديد)
            \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);
            
            // 3. تشغيل جميع الـ Seeders الأساسية (الدول، المدن، الجنسيات، المستخدمين، إلخ)
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);

            // 4. إضافة مناطق وأحياء الرياض المتطورة (V2)
            \Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--class' => 'RiyadhRegionsSeeder',
                '--force' => true
            ]);

            // 5. جلب أول جنسية مسجلة لاستخدامها في حساب المدير
            $natId = \Illuminate\Support\Facades\DB::table('nationalities')->first()->id;

            $safeNow = '2026-01-01 12:00:00';

            // 6. إنشاء حساب مدير (Admin) مضمون بكلمة سر سهلة للعميل وتغطية كل الحقول المطلوبة
            \App\Models\User::updateOrCreate(
                ['email' => 'admin@admin.com'],
                [
                    'name' => 'المدير العام',
                    'phone' => '0500000000',
                    'age' => 30,
                    'nationality_id' => $natId,
                    'type' => 1, // TYPE_ADMIN
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'email_verified_at' => $safeNow,
                    'status' => 1,
                    'created_at' => $safeNow,
                    'updated_at' => $safeNow
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'System Rebuilt Successfully',
                'admin_account' => 'admin@admin.com',
                'password' => 'password',
                'users_count' => \App\Models\User::count(),
                'countries' => \App\Models\Country::count(),
                'cities' => \App\Models\City::count(),
                'jwt_check' => config('jwt.secret') ? 'OK' : 'MISSING'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    });

    // Authenticated Admin
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });

        // Drivers
        Route::prefix('drivers')->name('drivers.')->group(function () {
            Route::get('/', [AdminDriverController::class, 'index'])->name('index');
            Route::get('{id}', [AdminDriverController::class, 'show'])->name('show');
            Route::post('{id}/status', [AdminDriverController::class, 'updateStatus'])->name('update-status');
        });

        // Customers
        Route::resource('customers', AdminCustomerController::class)->except(['create', 'store']);

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [AdminOrderController::class, 'index'])->name('index');
            Route::get('create', [AdminOrderController::class, 'create'])->name('create');
            Route::post('/', [AdminOrderController::class, 'store'])->name('store');
            Route::get('{id}', [AdminOrderController::class, 'show'])->name('show');
            Route::post('{id}/status', [AdminOrderController::class, 'updateStatus'])->name('update-status');
        });

        // Tickets
        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::get('/', [AdminTicketController::class, 'index'])->name('index');
            Route::get('{id}', [AdminTicketController::class, 'show'])->name('show');
            Route::post('{id}/status', [AdminTicketController::class, 'updateStatus'])->name('update-status');
        });

        // Notifications
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [AdminNotificationController::class, 'index'])->name('index');
            Route::get('create', [AdminNotificationController::class, 'create'])->name('create');
            Route::post('/', [AdminNotificationController::class, 'store'])->name('store');
            Route::post('mark-all-read', [AdminNotificationController::class, 'markAllAsRead'])->name('mark-all-read');
            Route::delete('{id}', [AdminNotificationController::class, 'destroy'])->name('destroy');
        });

        // Nationalities
        Route::resource('nationalities', AdminNationalityController::class);

        // Roles & Permissions
        Route::resource('roles', AdminRoleController::class);

        // Staff Management
        Route::resource('staff', AdminStaffController::class);

        // Regions & Neighborhoods
        Route::resource('regions', AdminRegionController::class);
        Route::get('regions/{region}/neighborhoods', [AdminRegionController::class, 'neighborhoods'])->name('regions.neighborhoods');
        Route::post('regions/{region}/neighborhoods', [AdminRegionController::class, 'storeNeighborhood'])->name('regions.neighborhoods.store');
        Route::delete('neighborhoods/{neighborhood}', [AdminRegionController::class, 'deleteNeighborhood'])->name('neighborhoods.destroy');

        // Captain Join Requests
        Route::prefix('captain-requests')->name('captain-requests.')->group(function () {
            Route::get('/', [AdminCaptainJoinRequestController::class, 'index'])->name('index');
            Route::post('{id}/status', [AdminCaptainJoinRequestController::class, 'updateStatus'])->name('update-status');
            Route::delete('{id}', [AdminCaptainJoinRequestController::class, 'destroy'])->name('destroy');
        });
    });
});
