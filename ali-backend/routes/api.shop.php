<?php

Route::post('register', 'AuthShopUsersController@register');

Route::post('login', 'AuthShopUsersController@login');

Route::group(['middleware' => 'jwt.api.shop'], function () {

    Route::get('user', 'AuthShopUsersController@user');

    Route::post('logout', 'AuthShopUsersController@logout');

    Route::get('allorder', 'OrdersController@allOrder');

    Route::post('updateorder', 'OrdersController@updateOrder');

    Route::get('vieworder', 'OrdersController@viewOrder');

    Route::get('rejectorder', 'OrdersController@rejectOrder');

    Route::post('filterorder', 'OrdersController@filterOrder');

    Route::get('continueorder', 'OrdersController@continueOrder');

    Route::get('chartShop', 'ShopsController@chartShop');

    Route::get('chartOrder', 'ShopsController@chartOrder');

    Route::get('chartProduct', 'ShopsController@chartProduct');

    Route::post('addproduct', 'ProductsController@addProduct');

    Route::get('listproduct', 'ProductsController@listProduct');

    Route::get('viewproduct', 'ProductsController@viewProduct');

    Route::post('updateproduct', 'ProductsController@updateProduct');

    Route::post('filterproduct', 'ProductsController@filterProduct');

    Route::post('createorder', 'OrdersController@createOrder');

    Route::post('addComment', 'OrdersController@addComment');

    Route::get('noti', 'OrdersController@noti');

    Route::get('vnpay', 'OrdersController@vnpay');

    Route::get('returnPay', 'OrdersController@returnPay');
});
