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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stripe-sample', function () {
    return view('stripe-sample');
});
Route::get('/braintree-sample', function () {
    return view('braintree-sample');
});

Route::post('/stripe-sample-db', 'CheckoutController@stripeCharge');
Route::get('/payment/process', 'CheckoutController@braintreeCharge')->name('payment.process');
Route::get('/braintree-sample-db', 'CheckoutController@braintreeSuccessMessage');
