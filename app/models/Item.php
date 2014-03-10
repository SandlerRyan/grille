<?php

use LaravelBook\Ardent\Ardent;

    class Item extends Ardent
    {
        public static $rules = array(
            'name' => 'required|min:1',
            'price' => 'required',
            'grille_id' => 'required|integer',
            'category_id' => 'required|integer'
        );
        
        public $timestamps = false;
        
    	public function category ()
    	{
    		return $this->belongsTo('Category');
    	}

    	public function grille ()
    	{
    		return $this->belongsTo('Grille');
    	}

        public function order ()
        {
            return $this->belongsToMany('Order', 'item_orders')->withPivot('id','quantity');
        }

        public function addon ()
        {
            return $this->belongsToMany('Addon', 'addon_items');
        }

    }
