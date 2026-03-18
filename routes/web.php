<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SafetyOptionController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\TeleCallerController;
use App\Http\Controllers\Admin\InsuranceController;
use App\Http\Controllers\Admin\BarcodeController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PromocodeController;
use App\Http\Controllers\Admin\ChartController;


use App\Http\Controllers\ProductController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SellerOrderController;
use App\Http\Controllers\user\UserDashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HireController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InsuranceController as Insurance;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cleared!";
});

Route::fallback(function () {
    return view('404');
});

Route::get('truncate', [App\Http\Controllers\HomeController::class, 'truncate']);

// Route::get('/', [Home::class, 'index']);
// Admin Route
Route::get('admin', [AdminLoginController::class, 'showAdminLoginForm'])->name('admin');
Route::post('admin/login', [AdminLoginController::class, 'adminLogin'])->name('admin.login');

Route::middleware(['redirect.url','auth:admin'])->prefix('admin')->group(function () {
    // middleware(['web', 'auth:admin'])->prefix('admin')
    Route::get('dashboard', [AdminLoginController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::resource('users', AdminUserController::class);
    Route::get('/user-del/{id}', [AdminUserController::class, 'destroy']);
    Route::post('admin-status', [AdminUserController::class, 'updateAdminStatus']);

    Route::get('/roles/{uid?}', [RoleController::class, 'index'])->name('roles');
    Route::post('/roles/store', [RoleController::class, 'store']);
    Route::delete('/roles-del/{id}', [RoleController::class, 'destroy'])->name('admin.del.role');
    Route::post('/roles-status', [RoleController::class, 'updateRoleStatus']);

    Route::get('/safety-option/{sid?}', [SafetyOptionController::class, 'index'])->name('safety-option.index');
    Route::post('/safety-option/store', [SafetyOptionController::class, 'store']);
    Route::get('/safety-del/{id}', [SafetyOptionController::class, 'destroy']);
    Route::post('/safety-status', [SafetyOptionController::class, 'updateSafetyStatus']);
    Route::get('/reason-data-info/{id}', [SafetyOptionController::class, 'view']);

    Route::resource('products', AdminProductController::class);
    Route::get('/products-del/{id}', [AdminProductController::class, 'destroy']);
    Route::post('products-status', [AdminProductController::class, 'updateProductStatus']);

    Route::get('add_emergency', [TeleCallerController::class, 'AddEmergency'])->name('admin.add_emergency');
    Route::any('search', [TeleCallerController::class, 'search']);
    Route::post('emergency/store', [TeleCallerController::class, 'storeEmergency']);
    Route::get('emergency', [TeleCallerController::class, 'EmergencyList'])->name('admin.emergency');
    Route::get('edit-emergency/{id}', [TeleCallerController::class, 'EditEmergency'])->name('admin.edit-emergency');
    Route::delete('del-emergency/{id}', [TeleCallerController::class, 'destroy'])->name('admin.del-emergency');
    Route::get('view-emergency/{id}', [TeleCallerController::class, 'view'])->name('admin.view-emergency');
    Route::get('call-emergency/{id}', [TeleCallerController::class, 'call_emergency'])->name('admin.call-emergency');
    Route::post('call-emergency/store', [TeleCallerController::class, 'storeCallEmergency'])->name('store.call-emergency');
    Route::get('emergency-history/{id}', [TeleCallerController::class, 'emergency_history'])->name('admin.emergency-history');
    Route::post('/emergency-update-status', [TeleCallerController::class, 'updateStatus'])->name('admin.emergency.update.status');

    Route::get('ins_enquiry', [InsuranceController::class, 'index'])->name('admin.ins_enquiry');
    Route::post('/ins-enquiry-status', [InsuranceController::class, 'updateInseEquiryStatus']);
    Route::get('view-ins-enquiry/{id}', [InsuranceController::class, 'view'])->name('admin.view-ins-enquiry');
    Route::get('insurance/create', [InsuranceController::class, 'addInsurance'])->name('admin.addInsurance');
    Route::post('ins/store', [InsuranceController::class, 'storeInsurance'])->name('admin.storeInsurance');

    Route::get('/insurance/{uid?}', [InsuranceController::class, 'insurance'])->name('admin.insurance');
    Route::post('/insurance/store', [InsuranceController::class, 'store'])->name('insurance.store');
    Route::delete('/insurance-del/{id}', [InsuranceController::class, 'destroy'])->name('admin.insurance.delete');
    Route::post('/insurance-status', [InsuranceController::class, 'updateinsuranceStatus'])->name('insurance.status.update');
    Route::get('/insurance-details/{uid?}', [InsuranceController::class, 'detailsInsurance'])->name('admin.insurance.details');
    Route::post('/insurance-details/store', [InsuranceController::class, 'detailsStore'])->name('insurance.details.store');

    // ADMIN sidebar
    Route::get('front_users', [AdminUserController::class, 'FrontUsers'])->name('admin.FrontUsers');
    Route::get('vehicles', [VehicleController::class, 'vehiclesList'])->name('admin.vehiclesList');
    Route::get('view-vehicle/{id}', [VehicleController::class, 'view'])->name('admin.view-vehicle');
    Route::post('/filter',[VehicleController::class, 'filter'])->name('filter');

    // Route::get('logout2', [AdminUserController::class, 'logout2']);
    Route::any('barcode', [BarcodeController::class, 'index'])->name('barcode');
    Route::get('barcode/create', [BarcodeController::class, 'create'])->name('barcode.create');
    Route::post('barcode/store', [BarcodeController::class, 'store'])->name('barcode.store');
    Route::get('/export_barcode/{code}', [BarcodeController::class, 'export_barcode'])->name('admin.export_barcode');
    Route::post('/barcode-status', [BarcodeController::class, 'BarcodeStatus']);
    Route::get('generate_barcode',[BarcodeController::class, 'generateBarcode'])->name('generate.barcode');
    Route::post('barcode/export',[BarcodeController::class, 'export'])->name('barcode.expert');
    Route::post('barcode_total',[BarcodeController::class, 'totalBarcode'])->name('total.barcode');
    Route::post('delete_file', [BarcodeController::class, 'delete_file']);
    Route::any('reassign/barcode/{code}', [BarcodeController::class, 'reAssign'])->name('reassign.barcode');
    Route::get('reassign/list', [BarcodeController::class, 'reassignList']);
    Route::post('barcode/reassign', [BarcodeController::class, 'reassignBarcode'])->name('barcode.reassign');

    Route::get('order/list', [OrderController::class, 'OrderList'])->name('order.list');
    Route::get('order/{orderId?}', [OrderController::class, 'OrderInfo']);
    Route::get('order/invoice/{orderId}',[OrderController::class, 'GenerateInvoice'])->name('admin.order.invoice');
    Route::post('/order/export', [OrderController::class, 'OrderExport'])->name('order.export');

    Route::get('alert/list', [TrackController::class, 'AlertList'])->name('alert.list');
    Route::get('view-alert/{id}', [TrackController::class, 'view'])->name('admin.view-alert');

    /* Banner */
    Route::get('/banner/{uid?}', [BannerController::class, 'index'])->name('banner');
    Route::post('/banner/store', [BannerController::class, 'store'])->name('banner.store');
    Route::delete('/banner-del/{id}', [BannerController::class, 'destroy'])->name('admin.banner.delete');
    Route::post('/banner-status', [BannerController::class, 'updateBannerStatus'])->name('banner.status.update');

    /* discount */
    Route::get('/discount', [DiscountController::class, 'index'])->name('discount');
    Route::post('/discount/store', [DiscountController::class, 'store'])->name('discount.store');

    /* setting */
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');
    Route::post('/setting/store', [SettingController::class, 'store'])->name('setting.store');

    /* Promocode */
    Route::get('/promocode/{uid?}',[PromocodeController::class, 'index'])->name('promocode');
    Route::post('/promocode/store',[PromocodeController::class, 'store'])->name('store.promocode');
    Route::delete('/promocode-del/{id}', [PromocodeController::class, 'destroy'])->name('promocode.delete');
    Route::post('/promocode-status', [PromocodeController::class, 'updateStatus'])->name('promocode.status.update');
    Route::post('/assign/promocode', [PromocodeController::class, 'assignPromocode'])->name('assign.promocode');

    /* Notification */
    Route::get('/notification',[NotificationController::class, 'index'])->name('notification');
    Route::post('/notification/store',[NotificationController::class, 'store'])->name('notification.store');

    /* Charts */
    Route::post('OrderChart',[ChartController::class, 'OrderChart']);
    Route::post('AlertChart',[ChartController::class, 'AlertChart']);
    Route::post('EmergencyChart',[ChartController::class, 'EmergencyChart']);
    Route::post('UserChart',[ChartController::class, 'UserChart']);
    Route::post('VehicleChart',[ChartController::class, 'VehicleChart']);
    Route::post('InsuranceChart',[ChartController::class, 'InsuranceChart']);

    /* Seller Admin Side */
    Route::get('barcode', [BarcodeController::class, 'index'])->name('barcode');
    Route::post('set-barcode', [BarcodeController::class, 'SetBarcodes']);
    Route::get('set-cust_del', [BarcodeController::class, 'SetCustomerDetial']);
    Route::any('search/customer', [BarcodeController::class, 'searchCustomer']);
    Route::post('seller/store_customer', [BarcodeController::class, 'store_customer']);
    Route::post('seller/promocode', [BarcodeController::class, 'sellerPromocode']);

    Route::get('seller/create_customer', [BarcodeController::class, 'CreateCustomer']);
    Route::post('user/register', [BarcodeController::class, 'user_register']);

    /* Hire Cab-Bus */
    Route::get('cab-enquiry',[HireController::class, 'cabEnquiry'])->name('admin.cab.enquiry');
    Route::get('bus-enquiry',[HireController::class, 'busEnquiry'])->name('admin.bus.enquiry');
    Route::post('enquiry/status',[HireController::class, 'updateStatus'])->name('admin.update.status');
    Route::get('view-hire-enquiry/{id}',[HireController::class, 'viewHireEnquiry'])->name('admin.viewhire.enquiry');
});

// Front Route
Auth::routes();
// Auth::routes(['register' => false]);

Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');

Route::get('/verify', [App\Http\Controllers\Auth\RegisterController::class, 'showVerificationForm'])->name('verify.form');
Route::post('/verify', [App\Http\Controllers\Auth\RegisterController::class, 'verify'])->name('verify');


Route::get('order/invoice/{orderId}',[OrderController::class, 'GenerateInvoice'])->name('order.invoice');

// Route::get('/', function () {
//     return view('front.home');
// });

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

Route::get('password/reset', [PasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [PasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::post('contact', [App\Http\Controllers\HomeController::class, 'contactUs'])->name('contact.us');
Route::get('rs-safety-tag', [App\Http\Controllers\HomeController::class, 'product'])->name('product');
Route::get('privacypolicy', [App\Http\Controllers\HomeController::class, 'privacypolicy'])->name('privacypolicy');

Route::get('privacypolicy', function () {
    return view('front.privacypolicy');
});

Route::get('termscondition', function () {
    return view('front.termscondition');
});

Route::get('logout',[App\Http\Controllers\Auth\LoginController::class,'logout'])->name('user.logout');
Route::get('my_account', [App\Http\Controllers\HomeController::class, 'MyProfile'])->name('my_account')->middleware('auth');
Route::post('user/update', [App\Http\Controllers\HomeController::class, 'update'])->name('user.update');

Route::get('edit-profile', [App\Http\Controllers\HomeController::class, 'EditProfile'])->name('edit-profile');

Route::get('store', [Insurance::class, 'index'])->name('store');
Route::get('insurance',[Insurance::class, 'Insurance'])->name('insurance');
Route::get('request-call-back-form-insurance',[Insurance::class, 'callBackInsurance'])->name('request.callback.insurance');
Route::post('add_ins_enquiry', [Insurance::class, 'AddInsEnquiry'])->name('add.ins.enquiry');
Route::post('insName', [Insurance::class, 'insName'])->name('insName');
Route::get('ins-details/{alias}',[Insurance::class,'insuranceDetails'])->name('insurance.details');

// Route::get('store', [ProductController::class, 'index'])->name('store');
// Route::get('cart', [ProductController::class, 'cart'])->name('cart');
// Route::get('add-to-cart', [ProductController::class, 'addToCart'])->name('add_to_cart');
// Route::patch('update-cart', [ProductController::class, 'update'])->name('update_cart');
// Route::delete('remove-from-cart', [ProductController::class, 'remove'])->name('remove_from_cart');

Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicles')->middleware('auth');
Route::post('getModels', [VehicleController::class, 'getModels'])->name('get.models');
Route::any('add-vehicle', [VehicleController::class, 'add'])->name('add.vehicle');
Route::post('store-vehicle', [VehicleController::class, 'store'])->name('store.vehicle');
Route::delete('/del-vehicle/{id}', [VehicleController::class, 'destroy'])->name('del.vehicle');
Route::get('/info-vehicle/{id}', [VehicleController::class, 'info'])->name('info.vehicle');
Route::get('/check-barcode/{barcode}', [VehicleController::class, 'checkBarcode']);
Route::get('/check-barcode', [VehicleController::class, 'checkBarcode']);
Route::post('/check-barcode', [VehicleController::class, 'checkBarcode']);
Route::post('/check-model', [VehicleController::class, 'CheckModel']);

Route::get('vehicle-details',[VehicleController::class, 'vehicleDetails'])->name('vehicle.details');
Route::get('edit-vehicle/{id?}', [VehicleController::class, 'edit'])->name('edit.vehicle');
Route::post('update-vehicle/{id?}', [VehicleController::class, 'update'])->name('update.vehicle');
Route::post('del-vehicle-img', [VehicleController::class, 'destroyImg']);

Route::get('track/{barcode?}', [TrackController::class, 'index']);
Route::get('safety-message/{id?}', [TrackController::class, 'GetSafetyMessage']);

Route::get('send-whatsapp-message', [TrackController::class, 'sendWhatsAppMessage']);
Route::post('send-message', [TrackController::class, 'sendMessage']); // not needed
Route::post('send-sms', [TrackController::class, 'sendSms']);

// Buy Now
// Route::get('cart', [StoreController::class, 'buyNow'])->name('BuyNow');
Route::post('add-to-cart', [CartController::class, 'AddToCart'])->name('add-to-cart');
Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::get('remove_from_cart', [CartController::class, 'remove']);
Route::post('update_cart', [CartController::class, 'updateCart'])->name('update.cart');
Route::post('check_qnt', [CartController::class, 'checkQnt']);
Route::post('get-promo-code', [CartController::class, 'GetPromoCode']);
Route::post('set-promo-code', [CartController::class, 'SetPromoCode']);
Route::post('check-promo-code', [CartController::class, 'CheckPromoCode']);

Route::post('gotocheckout', [CartController::class, 'GoToCheckout'])->name('gotocheckout');
Route::any('checkout', [CartController::class, 'checkout'])->name('checkout');

Route::get('order/details', [OrderController::class, 'orderListing'])->name('order.listing')->middleware('auth');
Route::post('order', [OrderController::class, 'order'])->name('order')->middleware('auth');
Route::any('/order/status', [OrderController::class, 'paymentCallback'])->name('status');
Route::any('/order/status-mobile', [OrderController::class, 'paymentCallback'])->name('mobile.status');


Route::post('thank_you', [OrderController::class, 'thank_you'])->name('thank_you')->middleware('auth');;
Route::get('order-detail/{orderId?}', [OrderController::class, 'OrderDetail'])->middleware('auth');;

Route::get('phonepe',[orderController::class,'phonePe']);
Route::any('phonepe-response',[orderController::class,'response'])->name('response');

Route::get('my_address',[AddressController::class,'myAddress'])->name('address')->middleware('auth');;
Route::any('add-address',[AddressController::class,'addAddress'])->name('add.address')->middleware('auth');;
Route::post('store-address',[AddressController::class,'store'])->name('store.address')->middleware('auth');;
Route::get('edit-address/{id?}',[AddressController::class,'edit'])->name('edit.address')->middleware('auth');;
Route::post('update-address',[AddressController::class,'update'])->name('update.address')->middleware('auth');;
Route::post('set_address_session', [AddressController::class, 'SetAddressSession']);

Route::any('address-form/{id?}',[AddressController::class,'AddressForm'])->name('address.form');
Route::any('address-form',[AddressController::class,'AddressForm'])->name('address.form');

Route::post('save-address',[AddressController::class,'save'])->name('save.address');
Route::delete('del-address/{addressId?}',[AddressController::class,'delete']);

Route::get('hire-cab',[HireController::class,'hireCab'])->name('hire.cab');
Route::get('hire-bus',[HireController::class,'hireBus'])->name('hire.bus');
Route::post('/hire-{hireType}-store', [HireController::class,'hireStore'])->name('hire.store');

Route::get('test_mail',[HomeController::class,'test_mail']);
Route::get('test_order',[HomeController::class,'test_order']);

