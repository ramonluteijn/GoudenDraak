<?php

use App\Http\Controllers\Admin\OrderCrudController;
use App\Http\Controllers\Admin\PageCrudController;
use App\Http\Controllers\Admin\SalesSummaryCrudController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ShoppingCartController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');


Route::group(['middleware' => 'RedirectIfAuthenticated'], function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
//    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login.save');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register.save');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile/orders', [OrderController::class, 'orderindex'])->name('orders.index');
    Route::get('/profile/orders/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/pages/{id}', [PageCrudController::class, 'delete'])->name('pages.delete');

    Route::prefix('/shop')->name('shop.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create-order', [OrderController::class, 'createEmptyOrder'])->name('create-order');
        Route::get('/add-to-cart/{id}', [OrderController::class, 'addToCart'])->name('addtocart');
        Route::get('/remove-from-cart/{id}', [OrderController::class, 'removeFromCart'])->name('removefromcart');
        Route::get('/cart', [ShoppingCartController::class, 'index'])->name('shoppingcart.index');
    });
});

//Route::get('/shop/cart', function () {
//    dd('This route is deprecated, please use /shop instead.');
//})->name('shoppingcart.index');

Route::get('/export/summary/{id}', [SalesSummaryCrudController::class, 'export'])->name('export-summary');
Route::get('/export/receipt/{id}', [OrderCrudController::class, 'export'])->name('export-receipt');
Route::get('/export/products', [\App\Exports\ProductExport::class, 'download'])->name('export-products');


Route::prefix('/survey')->name('survey.')->group(function () {
    Route::get('/', [QuestionController::class, 'index'])->name('index');
    Route::post('/', [QuestionController::class, 'store'])->name('store');
    Route::get('/confirmation', [QuestionController::class, 'confirmation'])->name('confirmation');
});
Route::get('/discounts', [DiscountController::class, 'index'])->name('discounts.index');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/destroy-session', [OrderController::class, 'destroySession'])->name('session.destroy');

Route::get('/{parent}/{child?}/{grandchild?}', [PageController::class, 'index'])->name('custom.read'); //always last route
