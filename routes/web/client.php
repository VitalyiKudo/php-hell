<?php

use App\Models\User;

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

Route::get('/', function () {
    return view('client.landing');
})->name('landing');
Route::get('/services', function () {
    return view('client.services');
});
Route::get('/aircraft', function () {
    return view('client.aircraft');
});
Route::get('/mobile-app', function () {
    return view('client.mobile-app');
});
Route::get('/about', function () {
    return view('client.about');
});
/*Route::get('/blog', function () {
    return view('client.blog');
});*/
Route::get('/terms-conditions', function () {
    return view('client.terms-conditions');
});
Route::get('/privacy-policy', function () {
    return view('client.privacy-policy');
});
Route::get('/listing-search', function () {
    return view('client.listing-search');
});

Route::permanentRedirect('/JetOnset', '/privacy-policy');
Route::permanentRedirect('/blog', 'https://blog.' . parse_url(config('app.url'), PHP_URL_HOST));

Route::get('/support', 'SupportController@index')->name('support');
Route::post('/support/client', 'SupportController@client')->name('support.client');
Route::post('/support/operator', 'SupportController@operator')->name('support.operator');
Route::post('/subscribed', 'SupportController@subscribe')->name('subscribed');

/* SiteMap */
Route::get('/sitemap', 'SitemapController@index');

/* EmptyLegs */
Route::get('/empty-leg', 'EmptyLegController@index')->name('empty-leg');

Auth::routes();

Route::namespace('Account')->group(function () {
    // Profile
    Route::get('/profile', 'Profile\PersonalInformationController@index')->name('profile');
    Route::put('/profile', 'Profile\PersonalInformationController@update')->name('profile.update');

    Route::get('/profile/account', 'Profile\AccountController@index')->name('profile.account.index');
    Route::put('/profile/account', 'Profile\AccountController@update')->name('profile.account.update');
    Route::delete('/profile/account', 'Profile\AccountController@destroy')->name('profile.account.destroy');

    Route::get('/profile/payment', 'Profile\PaymentController@index')->name('profile.payment.index');
    Route::post('/profile/payment', 'Profile\PaymentController@store')->name('profile.payment.store');
    Route::get('/profile/payment/{card}', 'Profile\PaymentController@show')->name('profile.payment.show');
    Route::delete('/profile/payment/{card}', 'Profile\PaymentController@destroy')->name('profile.payment.destroy');

    Route::get('/profile/companions', 'Profile\CompanionController@index')->name('profile.companions.index');
    Route::post('/profile/companions/store', 'Profile\CompanionController@store')->name('profile.companions.store');
    Route::get('/profile/companions/list', 'Profile\CompanionController@list')->name('profile.companions.list');
    Route::get('/profile/companion/{id}/edit', 'Profile\CompanionController@edit')->name('profile.companion.edit');
    Route::get('/profile/companion/{id}/delete', 'Profile\CompanionController@destroy')->name('profile.companion.delete');
    Route::put('/profile/companion/update', 'Profile\CompanionController@update')->name('profile.companion.update');

    Route::get('/profile/quote', 'Profile\QuoteController@index')->name('profile.quote.index');
    //Route::put('/profile/quote', 'Profile\QuoteController@update')->name('profile.quote.update');
    //Route::delete('/profile/quote', 'Profile\QuoteController@destroy')->name('profile.quote.destroy');
    // Orders
    Route::get('/requests', 'RequestController@index')->name('requests.index');


    // Orders
    Route::get('/orders', 'OrderController@index')->name('orders.index');
    Route::get('/orders/{order}/booking', 'OrderController@booking')->name('orders.booking');
    Route::post('/orders/{order}/booking', 'OrderController@payment')->name('orders.payment');
    #Route::get('/orders/{search}/confirm/{type}', 'OrderController@confirm')->name('orders.confirm');
    Route::get('/orders/confirm', 'OrderController@confirm')->name('orders.confirm');
    Route::get('/orders/{search}/confirm', 'OrderController@requestConfirm')->name('orders.request_confirm');
    #Route::match(['GET', 'POST'], '/orders/{search}/square', 'OrderController@square')->name('orders.square');
    Route::match(['GET', 'POST'], '/orders/{search}/square/{type}', 'OrderController@square')->name('orders.square');
    #Route::get('/orders/{search}/square/{type}', 'OrderController@square')->name('orders.square');
    #Route::match(['GET', 'POST'], '/orders/{search}/square', 'OrderController@requestSquare')->name('orders.request_square');
    //Route::get('/orders/confirm/', 'OrderController@confirm')->name('orders.confirm');
    Route::get('/orders/{order_id}/succeed/{type}', 'OrderController@succeed')->name('orders.succeed');
    Route::get('/orders/{order_id}/succeed', 'OrderController@request_succeed')->name('orders.request_succeed');
    Route::get('/orders/{order_id}/complete', 'OrderController@checkoutComplete')->name('orders.complete');
    //Route::match(['GET', 'POST'], '/orders/{search}/checkout/{type}', 'OrderController@checkout')->name('orders.checkout');

    //Flights search
    Route::get('/flights/search', 'SearchController@index')->name('search.index');
    Route::get('/search/flight', 'FlightController@index')->name('flight.index');
    //Route::post('/flights/quote', 'SearchController@requestQuote')->name('search.requestQuote');
    #Route::match(['GET', 'POST'], '/flights/quote', 'SearchController@requestQuote')->name('search.requestQuote');
    Route::get('/flights/quote', 'SearchController@requestQuote')->name('search.requestQuote');
    Route::get('/flights/quote/{order_id}/success', 'SearchController@requestQuoteSuccess')->name('search.requestQuoteSuccess');
    Route::get('/flights/success', 'SearchController@createQuote')->name('search.createQuote');

    Route::get('/flights/sendMail', 'SearchController@sendMail')->name('search.sendMail');

});

Route::get('/chats','ChatsController@index');
Route::get('/chat/{room_id}','ChatsController@getRoom')->name('chats.getRoom');
Route::get('/messages/{room_id}','ChatsController@fetchMessages');
Route::post('/messages','ChatsController@sendMessages');
