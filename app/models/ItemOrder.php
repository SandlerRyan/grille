<?php

    class ItemOrder extends Eloquent 
    {
    	public $timestamps = false;

    	public function addons()
    	{
    		return $this->belongsToMany('Addon','addon_item_orders');
    	}
    }
