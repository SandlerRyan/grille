<?php

    class Item extends Eloquent 
    {
        public $timestamps = false;
        
    	public function category ()
    	{
    		return $this->belongsTo('Category');
    	}

    	public function grille ()
    	{
    		return $this->belongsTo('Grille');
    	}

        public function orders ()
        {
            return $this->belongsToMany('Order', 'item_orders');
        }
    }
