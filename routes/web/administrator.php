<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware('auth:admin')->group(function () {
    
    Route::post('/orders/status', 'OrderController@UpdateStatus')->name('orders.status');
    Route::get('/', 'DashboardController')->name('dashboard');
    Route::resource('orders', 'OrderController');
    Route::resource('searches', 'SearchController');
    Route::resource('services', 'ServiceController');
    Route::resource('users', 'UserController');
    Route::resource('administrators', 'AdministratorController');

    
});
