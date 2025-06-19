<?php

use App\Http\Controllers\Admin\PageCrudController;
use App\Http\Controllers\Admin\SalesSummaryCrudController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');


Route::group(['middleware' => 'RedirectIfAuthenticated'], function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login.save');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register.save');

    Route::get('/pages/{id}', [PageCrudController::class, 'delete'])->name('pages.delete');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/profile/orders/{id}', [OrderController::class, 'show'])->name('order.show');
});

Route::get('/export/{id}', [SalesSummaryCrudController::class, 'export'])->name('export');

Route::prefix('/survey')->name('survey.')->group(function () {
    Route::get('/', [QuestionController::class, 'index'])->name('index');
    Route::post('/', [QuestionController::class, 'store'])->name('store');
    Route::get('/confirmation', [QuestionController::class, 'confirmation'])->name('confirmation');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/{parent}/{child?}/{grandchild?}', [PageController::class, 'index'])->name('custom.read');

