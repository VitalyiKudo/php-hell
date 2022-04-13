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
    Route::post('airport/import', 'AirportController@import')->name('airport.import');
    Route::post('pricing/import', 'PricingController@import')->name('pricing.import');
    Route::resource('airports', 'AirportController');
    Route::resource('airlines', 'AirlineController');
    Route::resource('pricing', 'PricingController');
    Route::resource('fees', 'FeesController');

    Route::post('api/airports','PricingController@getAutocompleteAirports')->name('api.airports');
    Route::post('api/cities','PricingController@getAutocompleteCities')->name('api.cities');
    Route::post('api/areas','PricingController@getAutocompleteAreas')->name('api.areas');
    Route::post('api/operators','PricingController@getAutocompleteOperators')->name('api.operators');
    Route::get('/airport/search','AirportController@search')->name('airport.search');
    Route::get('/airline/search','AirlineController@search')->name('airline.search');
    Route::get('/pricings/search','PricingController@search')->name('pricing.search');

    // Operator
    Route::get('/operator/search','OperatorController@search')->name('operator.search');
    Route::post('operator/import', 'OperatorController@import')->name('operator.import');
    Route::post('operator/ajaxValidationEmail', 'OperatorController@ajaxValidationEmail')->name('operator.ajaxValidationEmail');
    Route::post('operator/ajaxSearchCity', 'OperatorController@ajaxSearchCity')->name('operator.ajaxSearchCity');
    Route::post('operator/ajaxSearchAirport', 'OperatorController@ajaxSearchAirport')->name('operator.ajaxSearchAirport');
    Route::resource('operators', 'OperatorController');

    // EmptyLeg
    Route::get('emptyLeg/search','EmptyLegController@search')->name('emptyLeg.search');
    Route::post('emptyLeg/import', 'EmptyLegController@import')->name('emptyLeg.import');
    Route::post('emptyLeg/ajaxSearchOperator', 'EmptyLegController@ajaxSearchOperator')->name('emptyLeg.ajaxSearchOperator');
    Route::post('emptyLeg/ajaxSearchAirport', 'EmptyLegController@ajaxSearchAirport')->name('emptyLeg.ajaxSearchAirport');
    Route::resource('emptyLegs', 'EmptyLegController');

    // AirportArea
    Route::get('airportArea/search','AirportAreaController@search')->name('airportArea.search');
    Route::post('airportArea/import', 'AirportAreaController@import')->name('airportArea.import');
    Route::post('airportArea/ajaxSearchCity', 'AirportAreaController@ajaxSearchCity')->name('airportArea.ajaxSearchCity');
    Route::post('airportArea/ajaxSearchAirport', 'AirportAreaController@ajaxSearchAirport')->name('airportArea.ajaxSearchAirport');
    #Route::get('airportArea/ajaxDataList', 'AirportAreaController@ajaxDataList')->name('airportArea.ajaxDataList');
    Route::resource('airportAreas', 'AirportAreaController');

});
