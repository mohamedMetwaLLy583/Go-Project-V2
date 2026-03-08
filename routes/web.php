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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
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

    // Magic Upgrade Route (Fire and Forget)
    Route::get('/magic-upgrade', function () {
        try {
            // 1. تثبيت الجداول والتحديثات
            \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);
            
            // 2. إضافة الدولة الأساسية يدوياً لفك التعارض
            \Illuminate\Support\Facades\DB::table('countries')->insertOrIgnore([
                'id' => 1, 
                'name_ar' => 'السعودية', 
                'name_en' => 'Saudi Arabia', 
                'code' => '966', 
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 3. تنظيف ملفات الكاش
            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            
            // 4. إضافة البيانات الأساسية والمستخدمين (الدول، المدن، الأيام، الجنسيات، المستخدمين)
            \Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--force' => true
            ]);

            // 5. إضافة مناطق الرياض المتطورة (للمشروع v2)
            \Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--class' => 'RiyadhRegionsSeeder',
                '--force' => true
            ]);

            // 6. إضافة مدير مخصص إضافي لسهولة الدخول للعميل
            \App\Models\User::updateOrCreate(
                ['email' => 'admin@admin.com'],
                [
                    'name' => 'Admin User',
                    'type' => 1,
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'System has been successfully updated! (Migrations run + Cache cleared + Regions added)',
                'output' => \Illuminate\Support\Facades\Artisan::output()
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
    });
});
