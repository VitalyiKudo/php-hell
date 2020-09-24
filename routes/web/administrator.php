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
    Route::post('/orders/accepted', 'OrderController@orderAccepted')->name('orders.accepted');
    Route::resource('orders', 'OrderController');
    Route::resource('searches', 'SearchController');
    Route::resource('services', 'ServiceController');
    Route::resource('users', 'UserController');
    Route::resource('administrators', 'AdministratorController');
    Route::get('airports/csvstore', 'AirportController@csvStore')->name('airports.csvstore');
    Route::post('airline/import', 'AirlineController@import')->name('airline.import');
    Route::post('operator/import', 'OperatorController@import')->name('operator.import');
    Route::post('pricing/import', 'PricingController@import')->name('pricing.import');
    Route::resource('airports', 'AirportController');
    Route::resource('airlines', 'AirlineController');
    Route::resource('operators', 'OperatorController');
    Route::resource('pricing', 'PricingController');
    
    Route::post('api/airports','PricingController@getAutocompleteAirports')->name('api.airports');
    Route::post('api/cities','PricingController@getAutocompleteCities')->name('api.cities');
    
});
