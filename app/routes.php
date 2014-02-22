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

// Route called by ajax to increment an item (passes item id as argument)
Route::get('/increment/{id}', 'OrderController@increment');

// Route called by ajax to decrement an item
Route::get('/decrement/{id}', 'OrderController@decrement');

// Route called by ajax to empty a cart
Route::get('/empty_cart', 'OrderController@empty_cart');

//Route called by ajax to add a note
Route::get('/add_note/{id}/{note}', 'OrderController@add_note');

// Go to checkout after all menu items have been added to cart
Route::get('/checkout', 'OrderController@checkout');

//URL that Venmo redirects to when authentication is complete
Route::get('/authenticate_venmo', 'OrderController@authenticatePayment');

// Go here if the user opts to pay at the register
Route::get('/pay_later', 'OrderController@pay_later');

//Final Step in the Ordering Process
Route::get('/success', 'OrderController@success');


Route::controller('/', 'BaseController');
