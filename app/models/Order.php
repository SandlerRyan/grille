<?php

use LaravelBook\Ardent\Ardent;

class Order extends Ardent

{
    /**
     * Ardent validation rules
     */


    public static $rules = array(
      'user_id' => 'required',
      'grille_id' => 'required',
      'cost' => 'required',
      'fulfilled' => 'required'
    );



	public function user ()
	{
		return $this->belongsTo('User');
	}

	public function item_orders ()
	{
		return $this->belongsToMany('Item','item_orders')->withPivot('quantity','id','notes');
	}

    public function grille ()
    {
        return $this->belongsTo('Grille');
    }
}
