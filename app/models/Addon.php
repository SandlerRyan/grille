<?php

use LaravelBook\Ardent\Ardent;

class Addon extends Ardent
{
    public $timestamps = false;

    public static $rules = array(
      'name' => 'required|max:255',
      'price' => 'required',
      'available' => 'required|integer',
      'grille_id' => 'required|integer'
    );

	public function grille ()
	{
		return $this->belongsTo('Grille');
	}

	public function item ()
	{
		return $this->belongsToMany('Item','addon_items');
	}

}
