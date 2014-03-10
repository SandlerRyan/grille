<?php

use LaravelBook\Ardent\Ardent;

	class Inventory extends Eloquent
	{

		public static $rules = array(
          'name' => 'required|between:1,255',
          'quantity' => 'required|integer'
        );
	}