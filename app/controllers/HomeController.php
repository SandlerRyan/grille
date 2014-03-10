<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		//for now just hardcode that Eliot grille
		$grille_id = 1;
		$hours = Hour::where('grille_id', $grille_id)->get();

		foreach ($hours as $hour)
		{

			$open = strtotime($hour->open_time);
			$open = strtotime($hour->close_time);
		}
		return View::make('hello');
	}

}