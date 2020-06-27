<?php
Route::get('/', 'Admin\AdminsController@index')->name('hello')->middleware('check.login');

Route::get('shop', function () {
    return view('shop.login');
})->name('shop.login.view')->middleware('shop.checklogin');
