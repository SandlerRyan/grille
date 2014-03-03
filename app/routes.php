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
Route::get('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');
Route::get('/return_to', 'UserController@return_to');
Route::get('/add_phone/{phone}', 'UserController@add_phone');
Route::get('/edit_user/{id}', 'UserController@edit_user');
Route::get('/edit_test', 'UserController@edit_test');


/**
* CART CONTROLLER ROUTES
* All called by Ajax from order creation/checkout pages
*/
Route::get('/increment/{id}', 'CartController@increment');
Route::get('/decrement/{id}', 'CartController@decrement');
Route::get('/increment_addon/{addon_id}/{item_id}', 'CartController@increment_addon');
Route::get('/decrement_addon/{addon_id}/{item_id}', 'CartController@decrement_addon');
Route::get('/empty_cart', 'CartController@empty_cart');
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
Route::get('/admin/inventory', 'AdminController@inventory');
Route::get('/admin/filled_orders', 'AdminController@filled_orders');
Route::post('/refund_order/{id}', 'AdminController@refund_order');
Route::post('/get_new_orders', 'AdminController@get_new_orders');
Route::post('/mark_as_cooked/{id}', 'AdminController@mark_as_cooked');
Route::post('/mark_as_fulfilled/{id}', 'AdminController@mark_as_fulfilled');
Route::post('/mark_as_unavailable/{id}', 'AdminController@mark_as_unavailable');
Route::post('/mark_as_available/{id}', 'AdminController@mark_as_available');
Route::get('/alert_deals', 'AdminController@alert_deals');
Route::get('/alert_hours', 'AdminController@alert_hours');

/**
* INVENTORY TRACKING ROUTES
*/
Route::get('/inventory', 'InventoryController@show');



Route::controller('/', 'BaseController');




