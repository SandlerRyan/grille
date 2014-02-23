<?php

    class Category extends Eloquent 
    {
    	public $timestamps = false;
    	
    	public function items()
    	{
    		return $this->hasMany('Item');
    	}


    }
