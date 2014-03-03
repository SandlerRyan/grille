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

/**
* USER CONTROLLER ROUTES
* All called by Ajax from order creation/checkout pages
*/
// Go here when user clicks login
Route::get('/login', 'UserController@login');

// Go here when user clicks logout
Route::get('/logout', 'UserController@logout');

// Go here if the user opts to pay at the register
Route::get('/return_to', 'UserController@return_to');

// Called by ajax to add phone number of a user to databse
Route::get('/add_phone/{phone}', 'UserController@add_phone');

//post to store updated user info
Route::get('/edit_user/{id}', 'UserController@edit_user');


/**
* CART CONTROLLER ROUTES
* All called by Ajax from order creation/checkout pages
*/
// Route called by ajax to increment an item (passes item id as argument)
Route::get('/increment/{id}', 'CartController@increment');

// Route called by ajax to decrement an item
Route::get('/decrement/{id}', 'CartController@decrement');

// Route called by ajax to add an addon and associate it with an item
Route::get('/increment_addon/{addon_id}/{item_id}', 'CartController@increment_addon');

// Route called by ajax to remove an addon
Route::get('/decrement_addon/{addon_id}/{item_id}', 'CartController@decrement_addon');

// Route called by ajax to empty a cart
Route::get('/empty_cart', 'CartController@empty_cart');

//Route called by ajax to add a note
Route::get('/add_note/{id}/{note}', 'CartController@add_note');


/**
* ORDER CONTROLLER ROUTES
*/
// The default CRUD for creating, destroying, editing, orders
Route::resource('order', 'OrderController');

// Go to checkout after all menu items have been added to cart
Route::get('/checkout', 'OrderController@checkout');

//URL that Venmo redirects to when authentication is complete
Route::get('/authenticate_venmo', 'OrderController@authenticatePayment');

// Go here if the user opts to pay at the register
Route::get('/pay_later', 'OrderController@pay_later');

//Final Step in the Ordering Process
Route::get('/success', 'OrderController@success');

//send user a text message
Route::get('/send_sms/{phone}/{message}', 'OrderController@send_sms');



/**
* ADMIN DASHBOARD ROUTES
*/
Route::get('/admin', 'AdminController@dashboard');
Route::get('/filled_orders', 'AdminController@filled_orders');
Route::post('/refund_order/{id}', 'AdminController@refund_order');
Route::post('/get_new_orders', 'AdminController@get_new_orders');
Route::post('/mark_as_fulfilled/{id}', 'AdminController@mark_as_fulfilled');
Route::post('/mark_as_unavailable/{id}', 'AdminController@mark_as_unavailable');
Route::post('/mark_as_available/{id}', 'AdminController@mark_as_available');
Route::get('/alert_deals', 'AdminController@alert_deals');
Route::get('/alert_hours', 'AdminController@alert_hours');

Route::controller('/', 'BaseController');




