<?php
// route for shop users (manager for shop)
Route::get('/login', function () {
    return view('shop.login');
})->name('shop.login.view')->middleware('shop.checklogin');

Route::post('/login', 'AuthShopUsersController@login')->name('shop.login');

//Route for fix db
Route::get('fix/database', 'ShopsController@fixDatabase');

/*
Route::get('/register', function () {
    return view('shop.register');
})->name('shop.register');
*/

Route::post('/register', 'AuthShopUsersController@register')->name('shop.register');

Route::group(['middleware' => 'shop.check'], function () {

    Route::get('change-language/{language}', 'ShopsController@changeLanguage')->name('shop.change-language');

    Route::get('logout', 'AuthShopUsersController@logout')->name('shop.logout');

    Route::get('home', 'ShopsController@home')->name('shop.home');

    Route::get('processing/new', 'OrdersController@newOrder')->name('shop.processing.new');

    Route::get('processing/authenticated', 'OrdersController@authenticatedOrder')->name('shop.processing.authenticated');

    Route::get('orders', 'OrdersController@allOrder')->name('manageOrder');

    Route::get('repository', 'ProductsController@productsRequesting')->name('repo.products');

    /**
     * ajax route
     */

    Route::get('dialog-detail/order', 'OrdersController@dialogDetailOrder')->name('dialog.detail.order');

    Route::get('authenticate/order', 'OrdersController@authenticateOrder')->name('authenticate.order');

    Route::get('update/order', 'OrdersController@updateOrder')->name('update.order');

    Route::get('reject/order', 'OrdersController@rejectOrder')->name('reject.order');

    Route::get('filterOrder', 'OrdersController@filterOrder')->name('filterOrder');

    Route::get('continue/order', 'OrdersController@continueOrder')->name('continue.order');

    Route::get('dialog-detail/repo', 'ProductsController@dialogDetailRepo')->name('dialog.detail.repo');

    Route::get('update/orp-status', 'ProductsController@updateStatusOrderProduct')->name('update.orp.status');

    Route::get('add/shop-comment', 'CommentsController@addComment')->name('add.comment');

});

