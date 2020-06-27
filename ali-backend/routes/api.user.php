<?php

Route::post('register', 'AuthController@register');

Route::post('login', 'AuthController@login');

Route::group(['middleware' => 'jwt.api.user'], function () {

    Route::get('checklogin', 'AuthController@user');

    Route::post('logout', 'AuthController@logout');

    Route::get('addtocart', 'OrdersController@addToCart');

    Route::get('viewcart', 'OrdersController@viewCart');

    Route::post('removeorderproduct', 'OrderProductsController@removeOrderProduct');

    Route::post('updateorderproduct', 'OrderProductsController@updateOrderProduct');

    Route::post('order', 'OrdersController@order');

    Route::get('listorder', 'OrdersController@listOrder');

    Route::get('vieworder', 'OrdersController@viewOrder');

    Route::post('cancelorder', 'OrdersController@cancelOrder');

    Route::get('allorder/rejected', 'OrdersController@allOrderRejected');

    Route::post('comment', 'OrdersController@commentOrder');

    Route::get('comment', 'OrdersController@getComments');
});
