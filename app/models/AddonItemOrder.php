<?php

use LaravelBook\Ardent\Ardent;

    class AddonItemOrder extends Ardent
    {

    	public static $rules = array(
          'item_order_id' => 'required|integer',
          'addon_id' => 'required|integer',
          'quantity' => 'required|integer'
        );

    	public $timestamps = false;
    }
