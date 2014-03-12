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
* BIND THE GRILLE ID TO THE IOC CONTAINER
* This would be re-implemented with wildcard subdomain-matching
* on an Apache development server
*/
Route::group(array(), function()
{
	App::bind('grille_id', function () {
		return 1;
	});

	/**
	* USER CONTROLLER ROUTES
	* All called by Ajax from order creation/checkout pages
	*/
	Route::group(array('prefix' => 'user'), function()
	{
		Route::get('/login', 'UserController@login');
		Route::get('/logout', 'UserController@logout');
		Route::get('/return_to', 'UserController@return_to');
		Route::get('/edit_user', 'UserController@edit_user');
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
	Route::group(array('prefix' => 'dashboard', 'before' => 'auth|staff|grille'), function ()
	{
		Route::get('/', function () {
			$items = Item::where('grille_id', App::make('grille_id'))->get();
			return View::make('dashboard.index', ['items' => $items]);
		});
		Route::get('/filled_orders', function () {
			return View::make('dashboard.filled');
		});
		Route::get('/cancelled_orders', function () {
			return View::make('dashboard.cancelled');
		});
		Route::put('/send_text_blast/{message}', 'DashboardController@send_text_blast');
		
		Route::put('/toggle_open/', 'DashboardController@toggle_open');
		Route::post('/get_orders/{type}', 'DashboardController@get_orders');
		Route::post('/refund_order/{id}', 'DashboardController@refund_order');
		Route::post('/mark_as_cooked/{id}', 'DashboardController@mark_as_cooked');
		Route::post('/mark_as_fulfilled/{id}', 'DashboardController@mark_as_fulfilled');
		Route::post('/mark_as_unavailable/{id}', 'DashboardController@mark_as_unavailable');
		Route::post('/mark_as_available/{id}', 'DashboardController@mark_as_available');
		Route::post('/cancel/{id}', 'DashboardController@cancel');
		Route::get('/alert_deals', 'DashboardController@alert_deals');
		Route::get('/alert_hours', 'DashboardController@alert_hours');
	});

	/**
	* INVENTORY TRACKING ROUTES
	*/
	Route::group(array('prefix' => 'inventory', 'before' => 'auth|staff|grille'), function()
	{
		Route::get('/', 'InventoryController@index');
		Route::get('/increment/{id}', 'InventoryController@increment');
		Route::get('/decrement/{id}', 'InventoryController@decrement');
	});

	/**
	* ROUTE TO CHECK GRILLE OPENING
	* Chron job meant to be run every 10 minutes from easychron.com
	* Eventually this will be changed from a url to an artisan command
	*/
	Route::get('/check_open/cron/run/c68pd2s4e363221a3064e8807da20s1sf', function () {
		$grille_id = App::make('grille_id');
		$managers = User::where('grille_id', $grille_id)->where('privileges', 'manager')->get();
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
					foreach($managers as $manager) {
						Sms::send_sms($manager->phone_number, $message);
					}
				}
			}
		}

	});

	Route::controller('/', 'BaseController');

});
