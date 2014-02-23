<?php

    class Category extends Eloquent 
    {
    	public function items()
    	{
    		return $this->hasMany('Item');
    	}


    }
