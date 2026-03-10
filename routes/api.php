<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ConstantController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ApiProfileController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\DriverOrderRequestController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\SupportTicketController;
use App\Http\Controllers\Api\SettingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/




// Public constants API routes
Route::prefix('constants')->group(function () {
    Route::get('/countries', [ConstantController::class, 'countries']);
    Route::get('/cities', [ConstantController::class, 'cities']);
    Route::get('/days', [ConstantController::class, 'days']);
    Route::get('/neighborhoods', [ConstantController::class, 'neighborhoods']);
    Route::get('/nationalities', [ConstantController::class, 'nationalities']);
    Route::get('/regions', [ConstantController::class, 'regions']);
});

Route::prefix('otp')->group(function () {
    Route::post('/send-otp', [AuthController::class, 'sendOtp']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
});

Route::group(['middleware' => 'api'], function () {

    Route::prefix('auth')->group(function () {

        Route::post('login', [AuthController::class, 'login']);
        Route::post('register/user', [AuthController::class, 'registerUser']);
        Route::post('register/driver', [AuthController::class, 'registerDriver']);

        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [ApiProfileController::class, 'index']);
        Route::get('coins', [ApiProfileController::class, 'getCoins']);
        Route::delete('delete-account', [ApiProfileController::class, 'deleteAccount']);
        Route::post('update-account', [ApiProfileController::class, 'updateAccount']);
    });

    Route::prefix('messages')->group(function () {
        Route::post('/', [MessageController::class, 'store']);
    });
    Route::prefix('packages')->group(function () {
        Route::get('/', [PackageController::class, 'index']);
    });

    Route::prefix('drivers')->group(function () {
        Route::get('/', [DriverController::class, 'index']);
    });

    Route::prefix('sliders')->group(function () {
        Route::get('/', [SliderController::class, 'index']);
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/show/{id}', [NotificationController::class, 'show']);

        Route::post('/update/{id}', [NotificationController::class, 'update']);
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead']);

        Route::delete('/destroy/{id}', [NotificationController::class, 'destroy']);
        Route::delete('/destroy-all', [NotificationController::class, 'destroyAll']);
    });

    // Payment API
    Route::prefix('payments')->group(function () {
        Route::get('/', [PaymentController::class, 'index']);
        Route::post('/google', [PaymentController::class, 'store']);
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::get('/my-orders', [OrderController::class, 'my_orders']);
        Route::get('/my-applications', [OrderController::class, 'my_applications']);
        Route::post('/store', [OrderController::class, 'store']);
        Route::get('/show/{id}', [OrderController::class, 'show']);
        Route::post('/cancel/{id}', [OrderController::class, 'cancel_order']);
        Route::post('/{order}/notify-driver', [OrderController::class, 'notifyDriver']);

        // Driver Order Request

        // Driver applies to an order
        Route::post('/{order}/apply', [DriverOrderRequestController::class, 'apply']);
        // Customer views drivers who applied
        Route::get('/{order}/applications', [DriverOrderRequestController::class, 'applications']);
        // Customer accepts a driver
        Route::post('/applications/{application}/accept', [DriverOrderRequestController::class, 'accept']);
        // Customer rejects a driver
        Route::post('/applications/{application}/reject', [DriverOrderRequestController::class, 'reject']);
    });

    Route::prefix('wallet')->group(function () {
        Route::get('/', [WalletController::class, 'index']);
        Route::post('/deposit', [WalletController::class, 'deposit']);
        Route::post('/iap-charge', [WalletController::class, 'iapCharge']);
    });

    Route::prefix('ratings')->group(function () {
        Route::post('/', [RatingController::class, 'store']);
        Route::get('/user/{userId}', [RatingController::class, 'userRatings']);
    });

    Route::prefix('tickets')->group(function () {
        Route::get('/', [SupportTicketController::class, 'index']);
        Route::post('/', [SupportTicketController::class, 'store']);
        Route::get('/{id}', [SupportTicketController::class, 'show']);
    });

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index']);
        Route::get('/pages/{page}', [SettingController::class, 'getPage']);
    });
});
