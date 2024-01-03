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
Route::get('products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
# 公告
Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


Route::group(['middleware' => 'user'], function () {
    #購物車
    Route::get('cart_items', [App\Http\Controllers\CartItemController::class, 'index'])->name("cart_items.index");
    Route::post('cart_items/{product}/store', [App\Http\Controllers\CartItemController::class, 'store'])->name("cart_items.store");
    Route::get('cart_items/{cart_item}/edit', [App\Http\Controllers\CartItemController::class, 'edit'])->name("cart_items.edit");
    Route::patch('cart_items/{cart_item}/quantity_minus/a', [App\Http\Controllers\CartItemController::class, 'quantity_minus'])->name("cart_items.quantity_minus");
    Route::patch('cart_items/{cart_item}/quantity_plus', [App\Http\Controllers\CartItemController::class, 'quantity_plus'])->name("cart_items.quantity_plus");
    Route::patch('cart_items/{cart_item}/update', [App\Http\Controllers\CartItemController::class, 'update'])->name("cart_items.update");
    Route::delete('cart_items/{cart_item}', [App\Http\Controllers\CartItemController::class, 'destroy'])->name("cart_items.destroy");
    Route::post('cartItems/{product}/addToCart', [App\Http\Controllers\CartItemController::class, 'addToCart'])->name("cart_items.addToCart");

    #申請成為賣家
    Route::get('sellers/create', [App\Http\Controllers\SellerController::class, 'create'])->name("sellers.create");
    Route::post('sellers/{seller}/store', [App\Http\Controllers\SellerController::class, 'store'])->name("sellers.store");

    #買家訂單
    Route::get('orders', [App\Http\Controllers\OrderController::class, 'index'])->name("orders.index");
    Route::get('orders/create', [App\Http\Controllers\OrderController::class, 'create'])->name("orders.create");

    Route::post('orders', [App\Http\Controllers\OrderController::class, 'store'])->name("orders.store");
    Route::get('orders/filter', [App\Http\Controllers\OrderController::class, 'filter'])->name('orders.filter');
    Route::get('orders/{order}/show', [App\Http\Controllers\OrderController::class, 'show'])->name("orders.show");
    Route::get('orders/{order}/payment', [App\Http\Controllers\OrderController::class, 'payment'])->name("orders.payment");
    Route::patch('orders/{order}/update_pay', [App\Http\Controllers\OrderController::class, 'update_pay'])->name("orders.update_pay");
    Route::patch('orders/{order}/complete_order', [App\Http\Controllers\OrderController::class, 'complete_order'])->name("orders.complete_order");
    Route::patch('orders/{order}/cancel_order', [App\Http\Controllers\OrderController::class, 'cancel_order'])->name("orders.cancel_order");


});



require __DIR__.'/auth.php';


#賣家後台
Route::group(['middleware' => 'seller'], function () {
    Route::prefix('sellers')->name('sellers.')->group(function () {
        #商品管理
        Route::get('/products', [App\Http\Controllers\SellerProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [App\Http\Controllers\SellerProductController::class, 'create'])->name('products.create');
        Route::post('/products', [App\Http\Controllers\SellerProductController::class, 'store'])->name("products.store");
        Route::get('/products/{product}/edit', [App\Http\Controllers\SellerProductController::class, 'edit'])->name("products.edit");
        Route::patch('/products/{product}', [App\Http\Controllers\SellerProductController::class, 'update'])->name('products.update');
        Route::get('/products/search',[App\Http\Controllers\SellerProductController::class,'search'])->name('products.search');
        Route::patch('/products/{product}/reply', [App\Http\Controllers\SellerProductController::class, 'reply'])->name('products.reply');
        Route::patch('/products/{product}/statusoff', [App\Http\Controllers\SellerProductController::class, 'statusoff'])->name('products.statusoff');
        Route::patch('/products/{product}/statuson', [App\Http\Controllers\SellerProductController::class, 'statuson'])->name('products.statuson');
        Route::delete('/products/{product}', [App\Http\Controllers\SellerProductController::class, 'destroy'])->name("products.destroy");

        #訂單管理
        Route::get('/orders', [App\Http\Controllers\SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}/edit', [App\Http\Controllers\SellerOrderController::class, 'edit'])->name("orders.edit");
        Route::patch('/orders/{order}', [App\Http\Controllers\SellerOrderController::class, 'update'])->name('orders.update');
        Route::patch('/orders/{order}/pass', [App\Http\Controllers\SellerOrderController::class, 'pass'])->name('orders.pass');
        Route::patch('/orders/{order}/unpass', [App\Http\Controllers\SellerOrderController::class, 'unpass'])->name('orders.unpass');
        Route::patch('/orders/{order}/transport', [App\Http\Controllers\SellerOrderController::class, 'transport'])->name('orders.transport');
        Route::patch('/orders/{order}/arrive', [App\Http\Controllers\SellerOrderController::class, 'arrive'])->name('orders.arrive');
        Route::delete('/orders/{order}', [App\Http\Controllers\SellerOrderController::class, 'destroy'])->name("orders.destroy");
    });
});


# 管理員後台
Route::group(['middleware' => 'admin'], function () {
    Route::prefix('admins')->name('admins.')->group(function () {
        # 進入主控台頁面
        Route::get('/', [AdminDashboardController::class, 'index']);
        Route::get('/dashboard',[App\Http\Controllers\AdminDashboardController::class,'index'])->name('dashboard');

        # 用戶資料管理
        Route::get('/users',[App\Http\Controllers\AdminUserController::class,'index'])->name('users.index');
        Route::get('/users/search', [App\Http\Controllers\AdminUserController::class, 'search'])->name('users.search');
        Route::get('/users/create',[App\Http\Controllers\AdminUserController::class,'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\AdminUserController::class, 'store'])->name("users.store");
        Route::get('/users/{user}/edit', [App\Http\Controllers\AdminUserController::class, 'edit'])->name("users.edit");
        Route::patch('/users/{user}',[App\Http\Controllers\AdminUserController::class,'update'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\AdminUserController::class, 'destroy'])->name("users.destroy");

        # 賣家權限管理
        Route::get('/sellers',[App\Http\Controllers\AdminSellerController::class,'index'])->name('sellers.index');
        Route::get('/sellers/search', [App\Http\Controllers\AdminSellerController::class, 'search'])->name('sellers.search');
        Route::patch('/sellers/{seller}/statusOn',[App\Http\Controllers\AdminSellerController::class,'statusOn'])->name('sellers.statusOn');
        Route::patch('/sellers/{seller}/statusOff',[App\Http\Controllers\AdminSellerController::class,'statusOff'])->name('sellers.statusOff');
        Route::get('/sellers/{seller}/edit', [App\Http\Controllers\AdminSellerController::class, 'edit'])->name("sellers.edit");
        Route::patch('/sellers/{seller}/pass',[App\Http\Controllers\AdminSellerController::class,'pass'])->name('sellers.pass');
        Route::patch('/sellers/{seller}/unpass',[App\Http\Controllers\AdminSellerController::class,'unpass'])->name('sellers.unpass');
        Route::delete('/sellers/{seller}', [App\Http\Controllers\AdminSellerController::class, 'destroy'])->name("sellers.destroy");

        Route::get('/orders', [App\Http\Controllers\AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/search', [App\Http\Controllers\AdminOrderController::class, 'search'])->name('orders.search');
        Route::get('/orders/{order}/info', [App\Http\Controllers\AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}', [App\Http\Controllers\AdminOrderController::class, 'cancel'])->name("orders.cancel");

        Route::get('/moneys', [App\Http\Controllers\AdminMoneyController::class, 'index'])->name('moneys.index');
        Route::get('/moneys/search', [App\Http\Controllers\AdminMoneyController::class, 'search'])->name('moneys.search');


        //公告路由
        Route::get('/posts', [App\Http\Controllers\AdminPostController::class, 'index'])->name("posts.index");
        Route::get('/posts/search', [App\Http\Controllers\AdminPostController::class, 'search'])->name('posts.search');
        Route::get('/posts/create', [App\Http\Controllers\AdminPostController::class, 'create'])->name("posts.create");
        Route::post('/posts', [App\Http\Controllers\AdminPostController::class, 'store'])->name("posts.store");
        Route::get('/posts/{post}/edit', [App\Http\Controllers\AdminPostController::class, 'edit'])->name("posts.edit");
        Route::patch('/posts/{post}/statusOff', [App\Http\Controllers\AdminPostController::class, 'statusOff'])->name("posts.statusOff");
        Route::patch('/posts/{post}/statusOn', [App\Http\Controllers\AdminPostController::class, 'statusOn'])->name("posts.statusOn");
        Route::patch('/posts/{post}', [App\Http\Controllers\AdminPostController::class, 'update'])->name("posts.update");
        Route::delete('/posts/{post}', [App\Http\Controllers\AdminPostController::class, 'destroy'])->name("posts.destroy");

        //管理員權限管理
        Route::get('/admins',[App\Http\Controllers\AdminAdminController::class,'index'])->name('admins.index');
        Route::get('/admins/search', [App\Http\Controllers\AdminAdminController::class, 'search'])->name('admins.search');
        Route::get('/admins/create',[App\Http\Controllers\AdminAdminController::class,'create'])->name('admins.create');
        Route::get('/admins/create_selected/{id}',[App\Http\Controllers\AdminAdminController::class,'create_selcted'])->name('admins.create_selected');
        Route::post('/admins', [App\Http\Controllers\AdminAdminController::class, 'store'])->name("admins.store");
        Route::post('/admins', [App\Http\Controllers\AdminAdminController::class, 'store_level'])->name("admins.store_level");
        Route::get('/admins/{admin}/edit', [App\Http\Controllers\AdminAdminController::class, 'edit'])->name("admins.edit");
        Route::patch('/admins/{admin}',[App\Http\Controllers\AdminAdminController::class,'update'])->name('admins.update');
        Route::delete('/admins/{admin}', [App\Http\Controllers\AdminAdminController::class, 'destroy'])->name("admins.destroy");

        // 商品管理
        Route::get('/products',[App\Http\Controllers\AdminProductController::class,'index'])->name('products.index');
        Route::get('/products/search',[App\Http\Controllers\AdminProductController::class,'search'])->name('products.search');
        Route::get('/products/create',[App\Http\Controllers\AdminProductController::class,'create'])->name('products.create');
        Route::post('/products', [App\Http\Controllers\AdminProductController::class, 'store'])->name("products.store");
        Route::get('/products/{product}/edit', [App\Http\Controllers\AdminProductController::class, 'edit'])->name("products.edit");
        Route::get('/products/{product}/review',[App\Http\Controllers\AdminProductController::class,'review'])->name('products.review');
        Route::patch('/products/{product}',[App\Http\Controllers\AdminProductController::class,'update'])->name('products.update');
        Route::patch('/products/{product}/pass',[App\Http\Controllers\AdminProductController::class,'pass'])->name('products.pass');
        Route::patch('/products/{product}/unpass',[App\Http\Controllers\AdminProductController::class,'unpass'])->name('products.unpass');
        Route::delete('/products/{product}', [App\Http\Controllers\AdminProductController::class, 'destroy'])->name("products.destroy");

        Route::get('/product_categories',[App\Http\Controllers\AdminProductCategoryController::class,'index'])->name('product_categories.index');
        Route::get('/product_categories/search', [App\Http\Controllers\AdminProductCategoryController::class, 'search'])->name('product_categories.search');
        Route::get('/product_categories/create',[App\Http\Controllers\AdminProductCategoryController::class,'create'])->name('product_categories.create');
        Route::post('/product_categories', [App\Http\Controllers\AdminProductCategoryController::class, 'store'])->name("product_categories.store");
        Route::patch('/product_categories/{product_category}/statusOff', [App\Http\Controllers\AdminProductCategoryController::class, 'statusOff'])->name("product_categories.statusOff");
        Route::patch('/product_categories/{product_category}/statusOn', [App\Http\Controllers\AdminProductCategoryController::class, 'statusOn'])->name("product_categories.statusOn");
        Route::get('/product_categories/{product_category}/edit', [App\Http\Controllers\AdminProductCategoryController::class, 'edit'])->name("product_categories.edit");
        Route::patch('/product_categories/{product_category}',[App\Http\Controllers\AdminProductCategoryController::class,'update'])->name('product_categories.update');
        Route::delete('/product_categories/{product_category}', [App\Http\Controllers\AdminProductCategoryController::class, 'destroy'])->name("product_categories.destroy");
    });
});

