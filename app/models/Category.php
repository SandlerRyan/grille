<?php

use LaravelBook\Ardent\Ardent;

    class Category extends Ardent
    {

    	public static $rules = array(
          'name' => 'required, between:1,255'
        );

    	public $timestamps = false;
    	
    	public function items()
    	{
    		return $this->hasMany('Item');
    	}


    }
