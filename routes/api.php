<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OTPController;
use App\Http\Controllers\Api\Vehicle\BrandModelController;
use App\Http\Controllers\Api\Vehicle\VehicleController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\InsuranceController;
use App\Http\Controllers\Api\PromocodeController;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('send-otp',[CommonController::class,'sendOTP']);
Route::post('forgot-password',[ResetPasswordController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout', [AuthController::class, 'logOut']);
    Route::post('change-password',[ProfileController::class, 'changePassword']);
    Route::post('update-profile',[ProfileController::class, 'updateprofile']);

    Route::post('dashboard', [DashboardController::class, 'dashboard']);

    /* Vehicle */
    Route::post('vehicle/add', [VehicleController::class, 'addVehicle']);
    Route::post('vehicle/delete/{id}', [VehicleController::class, 'deleteVehicle']);
    Route::post('vehicle/barcode',[VehicleController::class, 'barcode']);
    Route::post('vehicle/image',[VehicleController::class, 'vehicleImage']);

    Route::post('brand',[BrandModelController::class,'brand']);
    Route::post('model',[BrandModelController::class,'model']);
    Route::post('vehicle/type',[BrandModelController::class, 'vehicleType']);

    Route::post('vehicle/track',[VehicleController::class, 'track']);
    Route::post('sms/track',[VehicleController::class, 'smsTrack']);

    Route::post('vehicle/document/delete',[VehicleController::class, 'vehicleDocDestroy']);

    /* Notification */
    Route::post('notification', [NotificationController::class, 'notification']);
    Route::post('reminder',[NotificationController::class, 'reminder']);
    Route::post('send/notification', [NotificationController::class, 'sendNotification']);

    /* Address */
    Route::post('address', [AddressController::class, 'index']);
    Route::post('address/add', [AddressController::class, 'addAddress']);
    Route::post('address/delete/{id}', [AddressController::class, 'delete']);

    /* order */
    Route::post('order', [OrderController::class, 'index']);
    Route::post('order/add', [OrderController::class, 'order']);

    /* discount */
    Route::post('discount', [DashboardController::class, 'discount']);

    Route::post('insurance', [InsuranceController::class, 'insuranceList']);
    Route::post('add/insurance', [InsuranceController::class, 'addInsurance']);

    Route::post('promocode', [PromocodeController::class, 'promocode']);
    Route::post('getdiscount', [PromocodeController::class, 'GetDiscount']);

    /* Cab & Bus Enquiry */
    Route::post('cab-bus-enq',[CommonController::class, 'hire_store']);

    /* Contact Us */
    Route::post('contactus',[CommonController::class, 'contactUs']);
});

Route::get('/terms-and-conditions', function () {
    return view('front.termscondition_Api');
})->name('terms-and-conditions');

Route::get('/privacy-policy', function () {
    return view('front.privacypolicy_Api');
})->name('privacy-and-policy');
