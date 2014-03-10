<?php

use LaravelBook\Ardent\Ardent;

    class Order extends Ardent
    {
        /**
         * Ardent validation rules
         */

       /* //create custom rule to make sure cost is not 0
        Validator::extend('notzero', function($attribute, $value, $parameters)
        {
            return $value > 0.0;
        });

        public static $customMessages = array(
            'notzero' => 'The :attribute must be greater than 0.'
        );*/

        public static $rules = array(
          'user_id' => 'required',
          'grille_id' => 'required',
          'cost' => 'required',
          'fulfilled' => 'required'
        );



    	public function user ()
    	{
    		return $this->belongsTo('User');
    	}

    	public function item_orders ()
    	{
    		return $this->belongsToMany('Item','item_orders')->withPivot('quantity','id');
    	}

        public function grille ()
        {
            return $this->belongsTo('Grille');
        }
    }
