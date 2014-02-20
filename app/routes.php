<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/



Route::post('/checkout', 'OrderController@checkout');

Route::resource('order', 'OrderController');

//URL that Venmo redirects to when authentication is complete
Route::get('/authenticate_venmo', 'OrderController@authenticatePayment');

Route::get('/pay_later', 'OrderController@pay_later');
//Final Step in the Ordering Process
Route::get('/success', 'OrderController@success');


Route::controller('/', 'BaseController');
