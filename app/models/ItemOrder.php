<?php

use LaravelBook\Ardent\Ardent;

    class ItemOrder extends Ardent
    {
    	public $timestamps = false;

    	public static $rules = array(
          'order_id' => 'required',
          'item_id' => 'required',
          'quantity' => 'required',
          'notes' => 'max:255'
        );


    	public function addons()
    	{
    		return $this->belongsToMany('Addon','addon_item_orders')->withPivot('quantity');
    	}
    }
