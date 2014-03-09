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
Route::group(array('prefix' => 'user'), function()
{
	Route::get('/login', 'UserController@login');
	Route::get('/logout', 'UserController@logout');
	Route::get('/return_to', 'UserController@return_to');
	Route::get('/add_phone/{phone}', 'UserController@add_phone');
	Route::get('/edit_user/{id}', 'UserController@edit_user');
	Route::get('/edit_test', 'UserController@edit_test');
});

/**
* CART CONTROLLER ROUTES
* All called by Ajax from order creation/checkout pages
*/
Route::group(array('prefix' => 'cart', 'before' => 'open'), function ()
{
	Route::get('/increment/{id}', 'CartController@increment');
	Route::get('/decrement/{id}', 'CartController@decrement');
	Route::get('/increment_addon/{addon_id}/{item_id}', 'CartController@increment_addon');
	Route::get('/decrement_addon/{addon_id}/{item_id}', 'CartController@decrement_addon');
	Route::get('/empty_cart', 'CartController@empty_cart');
	Route::get('/add_note/{id}/{note}', 'CartController@add_note');
});


/**
* ORDER CONTROLLER ROUTES
*/
// The default CRUD for creating, destroying, editing, orders
Route::group(array('prefix' => 'order', 'before' => 'open'), function ()
{
	Route::get('/create', 'OrderController@create');
	Route::get('/checkout', 'OrderController@checkout');
	Route::get('/authenticate_venmo', array('before' => 'auth', 'uses' => 'OrderController@authenticatePayment'));
	Route::get('/pay_later', array('before' => 'auth', 'uses' => 'OrderController@pay_later'));
	//Final Step in the Ordering Process; orders are stored here
	Route::get('/success', array('before' => 'auth', 'uses' => 'OrderController@success'));
});


/**
* ADMIN DASHBOARD ROUTES
*/

Route::group(array('prefix' => 'dashboard', 'before' => 'auth|staff'), function ()
{
	Route::get('/', 'AdminController@dashboard');
	Route::get('/filled_orders', 'AdminController@filled_orders');
	Route::post('/refund_order/{id}', 'AdminController@refund_order');
	Route::post('/get_new_orders', 'AdminController@get_new_orders');
	Route::post('/mark_as_cooked/{id}', 'AdminController@mark_as_cooked');
	Route::post('/mark_as_fulfilled/{id}', 'AdminController@mark_as_fulfilled');
	Route::post('/mark_as_unavailable/{id}', 'AdminController@mark_as_unavailable');
	Route::post('/mark_as_available/{id}', 'AdminController@mark_as_available');
	Route::get('/alert_deals', 'AdminController@alert_deals');
	Route::get('/alert_hours', 'AdminController@alert_hours');
});

/**
* INVENTORY TRACKING ROUTES
*/
Route::group(array('prefix' => 'inventory', 'before' => 'auth|staff'), function()
{
	Route::get('/', 'InventoryController@index');
	Route::get('/increment/{id}', 'InventoryController@increment');
	Route::get('/decrement/{id}', 'InventoryController@decrement');
});

/**
* ROUTE TO CHECK GRILLE OPENING
* Chron job meant to be run every 10 minutes
* Eventually this will be changed from a url to an artisan command
*/
Route::get('/check_open/cron/run/c68pd2s4e363221a3064e8807da20s1sf', function () {
	$grille_id = 1;
	$manager = User::where('grille_id', $grille_id)->where('privileges', 'manager')->get()[0];
	$hours = Hour::where('grille_id', $grille_id)->get();

	date_default_timezone_set('America/New_York');
	$now = new DateTime();
	$is_open = Grille::find($grille_id)->open_now;

	foreach($hours as $hour)
	{
		if ($hour->day_of_week != date('w')) continue;

		$open = new DateTime($hour->open_time);
		$close = new DateTime($hour->close_time);
		$interval = new DateInterval('PT15M');

		// send text alert if hours say grille should have closed within last 15 minutes
		if ($is_open) {
			if ($close < $now && $now < $close->add($interval)) {
				$message = 'NOTICE: The grille is listed as open outside of regular hours.';
				Sms::send_sms($manager->phone_number, $message);
			}
		}
		// send text alert if hours say grille should have opened within last 15 minutes
		else {
			if ($open < $now && $now < $open->add($interval)) {
				$message = 'NOTICE: The grille is listed as closed outside of regular hours.';
				Sms::send_sms($manager->phone_number, $message);
			}
		}
	}

});

Route::controller('/', 'BaseController');
