<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\WishlistController;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop/{category}', [HomeController::class, 'shop'])->name('shop');
Route::get('/view-product/{slug}', [HomeController::class, 'productDetails'])->name('productDetails');
Route::any('/contact', [HomeController::class, 'contact'])->name('contact');
Route::any('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::any('/login', [AuthController::class, 'login'])->name('login')->middleware("guest");
Route::any('/register', [AuthController::class, 'register'])->name('register')->middleware("guest");
Route::any('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verifyOtp')->middleware("guest");
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::resource('/checkout', CheckoutController::class);
Route::post('/checkout/payment-success', [CheckoutController::class, 'paymentSuccess'])->name('payment.success');


Route::get('demo', function () {
    $user = Auth::user();
    echo $user;
})->middleware("auth");



Route::resource('wishlist', WishlistController::class);
Route::resource('cart', CartController::class);
Route::post('aapply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
Route::delete('remove-coupon', [CartController::class, 'removeCoupon'])->name('remove-coupon');

Route::prefix('admin')->middleware(['auth', 'hasRole'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('discounts', DiscountController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'dashboard'])->name('user.profile');
    Route::post('/upload-photo', [UserController::class, 'uploadPhoto'])->name('user.photo');
});

//logout comman for all logged in user's

// Route::get('/about', [HomeController::class, 'about'])->name('about');
// Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// Route::get('/services', [HomeController::class, 'services'])->name('services');
// Route::get('/book_plan/{id}/{category}', [BookPlanController::class, 'plan'])->name('plan');
// Route::post('/save-plan', [BookPlanController::class, 'SavePlane'])->name('saveplan');
// Route::post('/user_request', [UserRequestController::class, 'userRequest'])->name('user-request');
// Route::get('/all-plans/{category}', [HomeController::class, 'AllPlansList'])->name('all-plans');


Route::any('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    //return redirect('/');
    die('cleared cache route config view');
});
