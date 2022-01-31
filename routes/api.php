<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('services', 'ServiceController@getServicesList');
Route::get('airports', 'AirportController@getAirportsList');
Route::get('types', 'AirportController@getTypesList');
Route::get('/avinode', 'AvinodeController@index')->name('avinode');
Route::post('/search/flights', 'AvinodeController@index')->name('flight.search');
Route::get('/requests/request/{start}/{end}/{startDate}/{endDate}', 'AvinodeController@request')->name('requests.request');

// Account
Route::get('profile/account', 'Account\Profile\AccountController@index');
Route::put('profile/account', 'Account\Profile\AccountController@update');
Route::delete('profile/account', 'Account\Profile\AccountController@destroy');
Route::put('profile/account/login', 'Account\Profile\AccountController@login');
Route::post('profile/account/register', 'Account\Profile\AccountController@register');
Route::put('profile/account/refresh', 'Account\Profile\AccountController@refresh');

// Requests
Route::get('requests', 'Account\RequestController@index');

// Companion
Route::get('profile/companions', 'Account\Profile\CompanionController@index');
Route::post('profile/companions/store', 'Account\Profile\CompanionController@store');
Route::get('profile/companions/list', 'Account\Profile\CompanionController@list');
Route::get('profile/companion/{id}/edit', 'Account\Profile\CompanionController@edit');
Route::get('profile/companion/{id}/delete', 'Account\Profile\CompanionController@destroy');

// Profile
Route::get('profile', 'Account\Profile\PersonalInformationController@index');
Route::put('profile', 'Account\Profile\PersonalInformationController@update');

Route::get('search/flight', 'Account\FlightController@index');

// Order
Route::get('orders', 'Account\OrderController@index');
Route::get('orders/{search}/confirm/{type}', 'Account\OrderController@confirm');

