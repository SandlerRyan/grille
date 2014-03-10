<?php

use LaravelBook\Ardent\Ardent;

    class Grille extends Ardent
    {

        public static $rules = array(
          'name' => 'required|between:1,255',
          'phone_number' => 'required|regex:"^\d{10}$"',
          'open_now' => 'integer'
        );


    	public function manager ()
    	{
    		return $this->belongsTo('User');
    	}

    	public function hours ()
    	{
    		return $this->hasMany('Hour');
    	}

    	public function items ()
    	{
    		return $this->hasMany('Item');
    	}

    	public function addons ()
    	{
    		return $this->hasMany('Addon');
    	}
    }
