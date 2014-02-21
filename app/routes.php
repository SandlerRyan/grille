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


// The default CRUD for creating, destroying, editing, orders
Route::resource('order', 'OrderController');

// Route called by ajax to increment an item
Route::get('/increment/{id}', 'OrderController@increment');

// Route::get('/increment/{id}', function($id)
// {
//     // Only called if {id} is numeric.
//     return $id;
// });
// Route called by ajax to decrement an item
Route::get('/decrement/{id}', 'OrderController@decrement');

// Route called by ajax to empty a acart
Route::get('/empty_cart', 'OrderController@empty_cart');

// Go to checkout after all menu items have been added to cart
Route::post('/checkout', 'OrderController@checkout');

//URL that Venmo redirects to when authentication is complete
Route::get('/authenticate_venmo', 'OrderController@authenticatePayment');

// Go here if the user opts to pay at the register
Route::get('/pay_later', 'OrderController@pay_later');

//Final Step in the Ordering Process
Route::get('/success', 'OrderController@success');


Route::controller('/', 'BaseController');
