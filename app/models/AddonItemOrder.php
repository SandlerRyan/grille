<?php

use LaravelBook\Ardent\Ardent;

    class AddonItemOrder extends Eloquent 
    {

    	public static $rules = array(
          'item_order_id' => 'required, integer',
          'addon_id' => 'required, integer',
          'quantity' => 'required, integer'
        );

    	public $timestamps = false;
    }
