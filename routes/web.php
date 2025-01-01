<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\user\UserController;
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
Route::get('/shop-cart', [HomeController::class, 'shopCart'])->name('shopCart');
Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
Route::any('/contact', [HomeController::class, 'contact'])->name('contact');

Route::any('/login', [HomeController::class, 'login'])->name('login')->middleware("guest");
Route::any('/register', [HomeController::class, 'register'])->name('register')->middleware("guest");
Route::any('/verify-otp', [HomeController::class, 'VerifyOtp'])->name('VerifyOtp')->middleware("guest");
Route::get('/logout', [HomeController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('demo', function () {

    $user = Auth::user();
    echo $user;
})->middleware("auth");

Route::get('test', function () {

    //roles function is a global fuction of helper folder file which allows us to access the method of file without calling or using the class file.
    // $roles = roles();
    // print_r($roles);

    // $users = User::all();
    // $users = User::get();
    // $users = User::first();



    // $result = User::with("roles")->first();
    // print_r($result->hasRole("user"));

    // $result = $users->append(['team', 'is_admin']);
    // $result = $users->contains("email", "khetsinghyogi@gmail.com");
    // $result = $users->findOrFail(1);
    // $result = $users->setVisible(['id', 'name']);
    // $result = $users->makeHidden(['id', 'name']);
    // $result = $users->modelKeys();
    // $result = $users->only([1, 2, 3]);



    //    $result = $users->append(['team', 'is_admin']);


    // $result = $result->hasRole("super-admin");

    // print_r(Auth::user()->id);
    // print_r($result["roles"][0]["permissions"]);

    // $role = Session::get("roleName");
    // print_r($role);
    // $result = User::select("id")->with("roles:id,name", "roles.permissions:id,name")->find(Auth::user()->id)->toArray();

});


Route::prefix('admin')->middleware(['auth', 'checkAdmin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::any('/add-product', [AdminController::class, 'addPrduct'])->name('admin.addProduct');
    Route::get('/edit-product/{productId}', [AdminController::class, 'editProduct'])->name('admin.editProduct');
    Route::post('/edit-product', [AdminController::class, 'editProduct'])->name('admin.editProductRequest');
    Route::get('/delete-product/{productId}', [AdminController::class, 'deleteProduct'])->name('admin.deleteProduct');
    Route::get('/view-product/{productId}', [AdminController::class, 'viewProduct'])->name('admin.viewProduct');
    Route::get('/list-product', [AdminController::class, 'listProduct'])->name('admin.listProduct');

    //category routes
    Route::any('/add-category', [AdminController::class, 'addCategory'])->name('admin.addCategory');
    Route::get('/edit-category/{category}', [AdminController::class, 'editCategory'])->name('admin.editCategory');
    Route::post('/edit-category', [AdminController::class, 'editCategory'])->name('admin.editCategoryRequest');
    Route::get('/delete-category/{category}', [AdminController::class, 'deletedCategory'])->name('admin.deleteCategory');
    Route::get('/list-category', [AdminController::class, 'listCategory'])->name('admin.listCategory');
});

Route::middleware(['auth', 'checkUser'])->group(function () {

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
