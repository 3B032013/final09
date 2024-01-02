<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CartItemController;

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



Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('home');
Route::get('products/{product}/show', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


Route::group(['middleware' => 'user'], function () {
    Route::get('cart_items', [App\Http\Controllers\CartItemController::class, 'index'])->name("cart_items.index");
    Route::post('cart_items/{product}/store', [App\Http\Controllers\CartItemController::class, 'store'])->name("cart_items.store");
    Route::get('cart_items/{cart_item}/edit', [App\Http\Controllers\CartItemController::class, 'edit'])->name("cart_items.edit");
    Route::patch('cart_items/{cart_item}', [App\Http\Controllers\CartItemController::class, 'update'])->name("cart_items.update");
    Route::delete('cart_items/{cart_item}', [App\Http\Controllers\CartItemController::class, 'destroy'])->name("cart_items.destroy");
});



require __DIR__.'/auth.php';


# 管理員後台
Route::group(['middleware' => 'admin'], function () {
    Route::prefix('admins')->name('admins.')->group(function () {
        # 進入主控台頁面
        Route::get('/', [AdminDashboardController::class, 'index']);
        Route::get('/dashboard',[App\Http\Controllers\AdminDashboardController::class,'index'])->name('dashboard');

        # 用戶資料管理
        Route::get('/users',[App\Http\Controllers\AdminUserController::class,'index'])->name('users.index');
        Route::get('/users/create',[App\Http\Controllers\AdminUserController::class,'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\AdminUserController::class, 'store'])->name("users.store");
        Route::get('/users/{user}/edit', [App\Http\Controllers\AdminUserController::class, 'edit'])->name("users.edit");
        Route::patch('/users/{user}',[App\Http\Controllers\AdminUserController::class,'update'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\AdminUserController::class, 'destroy'])->name("users.destroy");

        # 賣家權限管理
        Route::get('/sellers',[App\Http\Controllers\AdminSellerController::class,'index'])->name('sellers.index');
        Route::patch('/sellers/{seller}/statusOn',[App\Http\Controllers\AdminSellerController::class,'statusOn'])->name('sellers.statusOn');
        Route::patch('/sellers/{seller}/statusOff',[App\Http\Controllers\AdminSellerController::class,'statusOff'])->name('sellers.statusOff');
        Route::get('/sellers/{seller}/edit', [App\Http\Controllers\AdminSellerController::class, 'edit'])->name("sellers.edit");
        Route::patch('/sellers/{seller}/pass',[App\Http\Controllers\AdminSellerController::class,'pass'])->name('sellers.pass');
        Route::patch('/sellers/{seller}/unpass',[App\Http\Controllers\AdminSellerController::class,'unpass'])->name('sellers.unpass');
        Route::delete('/sellers/{seller}', [App\Http\Controllers\AdminSellerController::class, 'destroy'])->name("sellers.destroy");

        //管理員權限管理
        Route::get('/admins',[App\Http\Controllers\AdminAdminController::class,'index'])->name('admins.index');
        Route::get('/admins/create',[App\Http\Controllers\AdminAdminController::class,'create'])->name('admins.create');
        Route::get('/admins/create_selected/{id}',[App\Http\Controllers\AdminAdminController::class,'create_selcted'])->name('admins.create_selected');
        Route::post('/admins', [App\Http\Controllers\AdminAdminController::class, 'store'])->name("admins.store");
        Route::post('/admins', [App\Http\Controllers\AdminAdminController::class, 'store_level'])->name("admins.store_level");
        Route::get('/admins/{admin}/edit', [App\Http\Controllers\AdminAdminController::class, 'edit'])->name("admins.edit");
        Route::patch('/admins/{admin}',[App\Http\Controllers\AdminAdminController::class,'update'])->name('admins.update');
        Route::delete('/admins/{admin}', [App\Http\Controllers\AdminAdminController::class, 'destroy'])->name("admins.destroy");

        // 商品管理
        Route::get('/products',[App\Http\Controllers\AdminProductController::class,'index'])->name('products.index');
        Route::get('/products/create',[App\Http\Controllers\AdminProductController::class,'create'])->name('products.create');
        Route::post('/products', [App\Http\Controllers\AdminProductController::class, 'store'])->name("products.store");
        Route::get('/products/{product}/edit', [App\Http\Controllers\AdminProductController::class, 'edit'])->name("products.edit");
        Route::patch('/products/{product}',[App\Http\Controllers\AdminProductController::class,'update'])->name('products.update');
        Route::delete('/products/{product}', [App\Http\Controllers\AdminProductController::class, 'destroy'])->name("products.destroy");
    });
});

