<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/product-details/{category}/{childcategory}', [HomeController::class, 'productDetails'])->name('productDetails');
Route::get('/shop-cart', [HomeController::class, 'shopCart'])->name('shopCart');
Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
Route::any('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/loginRequest', [HomeController::class, 'loginRequest'])->name('loginRequest');
Route::get('/register', [HomeController::class, 'register'])->name('register');

Route::get('demo', function () {
    $user = Auth::user();
    echo $user;
});


Route::prefix('admin')->middleware(['checkAdmin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::any('/add-product', [AdminController::class, 'addPrduct'])->name('admin.addProduct');
    Route::get('/edit-product/{productId}', [AdminController::class, 'editProduct'])->name('admin.editProduct');
    Route::post('/edit-product', [AdminController::class, 'editProduct'])->name('admin.editProductRequest');
    Route::get('/list-product', [AdminController::class, 'listProduct'])->name('admin.listProduct');

    //category routes
    Route::any('/add-category', [AdminController::class, 'addCategory'])->name('admin.addCategory');
    Route::get('/edit-category/{category}', [AdminController::class, 'editCategory'])->name('admin.editCategory');
    Route::post('/edit-category', [AdminController::class, 'editCategory'])->name('admin.editCategoryRequest');
    Route::get('/delete-category/{category}', [AdminController::class, 'deletedCategory'])->name('admin.deleteCategory');
    Route::get('/list-category', [AdminController::class, 'listCategory'])->name('admin.listCategory');
    
});

Route::middleware(['checkUser'])->group(function () {

    Route::get('/profile', [UserController::class, 'dashboard'])->name('user.profile');
});

//logout comman for all logged in user's
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

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
