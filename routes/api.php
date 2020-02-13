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
Route::get('/avinode', 'AvinodeController@index')->name('avinode');
Route::post('/search/flights', 'AvinodeController@index')->name('flight.search');
Route::get('/requests/request/{start}/{end}/{startDate}/{endDate}', 'AvinodeController@request')->name('requests.request');
