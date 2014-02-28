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


// Go here when user clicks login
Route::get('/login', 'UserController@login');

// Go here when user clicks logout
Route::get('/logout', 'UserController@logout');

// Go here if the user opts to pay at the register
Route::get('/return_to', 'UserController@return_to');

// The default CRUD for creating, destroying, editing, orders
Route::resource('order', 'OrderController');

// Route called by ajax to increment an item (passes item id as argument)
Route::get('/increment/{id}', 'OrderController@increment');

// Route called by ajax to decrement an item
Route::get('/decrement/{id}', 'OrderController@decrement');

// Route called by ajax to add an addon and associate it with an item
Route::get('/increment_addon/{item_id}/{addon_id}', 'OrderController@increment_addon');

// Route called by ajax to remove an addon
Route::get('/decrement_addon/{item_id}/{addon_id}', 'OrderController@decrement_addon');

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

Route::get('/admin', 'AdminController@dashboard');
Route::get('/filled_orders', 'AdminController@filled_orders');
Route::post('/refund_order/{id}', 'AdminController@refund_order');
Route::post('/get_new_orders', 'AdminController@get_new_orders');
Route::post('/mark_as_fulfilled/{id}', 'AdminController@mark_as_fulfilled');
Route::post('/mark_as_unavailable/{id}', 'AdminController@mark_as_unavailable');
Route::post('/mark_as_available/{id}', 'AdminController@mark_as_available');

Route::controller('/', 'BaseController');
