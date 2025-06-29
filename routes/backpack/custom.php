<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('product', 'ProductCrudController');
    Route::crud('table', 'TableCrudController');
    Route::crud('order', 'OrderCrudController');
    Route::crud('question', 'QuestionCrudController');
    Route::crud('page', 'PageCrudController');
    Route::crud('menu-item', 'MenuItemCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('sales-summary', 'SalesSummaryCrudController');
    Route::crud('discount', 'DiscountCrudController');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
