<?php

use LaravelBook\Ardent\Ardent;

class AddonItem extends Ardent
{

	public static $rules = array(
      'item_id' => 'required|integer',
      'addon_id' => 'required|integer'
    );

	public $timestamps = false;

}
