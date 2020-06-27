<?php

Route::group(['namespace' => 'Admin'], function () {

    Route::get('login', 'AdminsController@welcomeLogin')->name('login')->middleware('check.login');

    Route::get('register', 'AdminsController@welcomeRegister')->name('register')->middleware('check.login');

    Route::post('register', 'AdminsController@registerAdmin')->name('registerAdmin');

    Route::get('activation/{token}', 'AdminsController@activateAdmin')->name('admin.activate');

    Route::post('login', 'AdminsController@loginAdmin');
});

Route::group(['middleware' => 'check.admin', 'namespace' => 'Admin'], function () {

    Route::get('welcome', 'AdminsController@welcome')->name('welcome');

    Route::get('admins', 'AdminsController@manageAdmin')->name('manageAdmin');

    Route::get('newadmins', 'AdminsController@manageNewAdmin')->name('manageNewAdmin');

    Route::get('users', 'UsersController@manageUser')->name('manageUser');

    Route::get('newusers', 'UsersController@manageNewUser')->name('manageNewUser');

    Route::get('shops', 'ShopsController@manageShop')->name('manageShop');

    Route::get('newshops', 'ShopsController@manageNewShop')->name('manageNewShop');

    Route::get('shopuser', 'ShopUsersController@manageShopUser')->name('manageShopUser');

    Route::get('products', 'ProductsController@manageProduct')->name('manageProduct');

    Route::get('newproducts', 'ProductsController@manageNewProduct')->name('manageNewProduct');

    Route::get('shoporders', 'OrdersController@manageShopOrder')->name('manageShopOrder');

    Route::get('delete_admin', 'AdminsController@deleteAdmin')->name('deleteAdmin');

    Route::get('disable_user', 'UsersController@disableUser')->name('disableUser');

    Route::get('disable_shop', 'ShopsController@disableShop')->name('disableShop');

    Route::get('disable_shopuser', 'ShopUsersController@disableShopUser')->name('disableShopUser');

    Route::get('disable_shoporder', 'OrdersController@disableShopOrder')->name('disableShopOrder');

    Route::get('disable_product', 'ProductsController@disableProduct')->name('disableProduct');

    Route::get('filterAdmin', 'AdminsController@filterAdmin')->name('filterAdmin');

    Route::get('filterUser', 'UsersController@filterUser')->name('filterUser');

    Route::get('filterShop', 'ShopsController@filterShop')->name('filterShop');

    Route::get('detailOrder', 'OrdersController@viewDetailOrder')->name('viewDetailOrder');

    Route::get('setting', 'SettingsController@setting')->name('setting');

    Route::get('logout', 'AdminsController@logoutAdmin')->name('logout');
});
