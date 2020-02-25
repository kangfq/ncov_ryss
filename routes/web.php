<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//首页
Route::get('/', function () {
    return view('home.index');
});

Auth::routes();

//个人中心
Route::get('/home', 'HomeController@index')->name('home');

//常用信息
Route::prefix('info')->name('info.')->group(function () {
    Route::get('/', 'InfoController@index')->name('index');
    Route::get('buy', 'InfoController@buy')->name('buy');
    Route::get('mdl', 'InfoController@mdl')->name('mdl');
    Route::get('zb', 'InfoController@zb')->name('zb');
});

Route::middleware('auth')->group(function () {
//地址管理
    Route::prefix('address')->name('address.')->group(function () {
        Route::get('/', 'AddressController@index')->name('index');
        Route::post('store', 'AddressController@store')->name('store');
        Route::delete('destroy/{id}', 'AddressController@destroy')->name('destroy')->middleware('admin');
    });

//订单管理
    Route::prefix('order')->name('order.')->group(function () {
        Route::get('/', 'OrderController@index')->name('index');
        Route::get('create/{mall_id}', 'OrderController@create')->name('create');
        Route::post('store', 'OrderController@store')->name('store');
        Route::get('show/{id}', 'OrderController@show')->name('show');
        Route::post('success/{id}', 'OrderController@success')->name('success');
        Route::delete('destroy/{id}', 'OrderController@destroy')->name('destroy');
        Route::get('export_order/{id}', 'OrderController@export_order')->middleware('admin')->name('export_order');
    });
//商品管理
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/', 'productController@index')->name('index');
        Route::get('/create', 'productController@create')->name('create');
        Route::post('store', 'productController@store')->name('store');
    });
//购物车
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/{mall_id}', 'CartController@index')->name('index');
        Route::post('store', 'CartController@store')->name('store');
        Route::delete('destroy/{id}', 'CartController@destroy')->name('destroy');
    });
});

//后台管理
Route::prefix('admin')->middleware('auth', 'admin')->name('admin.')->group(function () {
    Route::get('/', 'AdminController@index')->name('index');
    Route::get('create/{mall_id}', 'AdminController@create')->name('create');
    Route::post('store', 'AdminController@store')->name('store');
    Route::get('edit/{mall_id}/{id}', 'AdminController@edit')->name('edit');
    Route::put('update/{id}', 'AdminController@update')->name('update');
    Route::delete('destroy/{id}', 'AdminController@destroy')->name('destroy');
    Route::post('pay', 'AdminController@pay')->name('pay');
    Route::post('pay_back', 'AdminController@pay_back')->name('pay_back');
    Route::get('product/{mall_id}', 'AdminController@product')->name('product');
    Route::get('order/{mall_id}', 'AdminController@order')->name('order');
    Route::post('trigger/{id}', 'AdminController@trigger')->name('trigger');
    Route::get('total_order/{mall_id}', 'AdminController@total_order')->name('total_order');

    //订单回收站
    Route::prefix('recycle')->name('recycle.')->group(function () {
        Route::get('/{mall_id}', 'OrderRecycleController@index')->name('index');
        Route::post('back_order', 'OrderRecycleController@back_order')->name('back_order');
        Route::delete('destroy/{id}', 'OrderRecycleController@destroy')->name('destroy');
    });

    //用户管理
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', 'UserController@index')->name('index');
        Route::get('edit/{id}', 'UserController@edit')->name('edit');
        Route::put('update/{id}', 'UserController@update')->name('update');
    });
});




