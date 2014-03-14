<?php

use LaravelBook\Ardent\Ardent;

	class Inventory extends Ardent
	{

		public static $rules = array(
		  'grille_id' => 'required|integer',
          'name' => 'required|between:1,255',
          'quantity' => 'required|integer',
          'units' => 'required'
        );
	}