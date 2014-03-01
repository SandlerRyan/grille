<?php

    class Order extends Eloquent 
    {
    	public function user ()
    	{
    		return $this->belongsTo('User');
    	}

    	public function item_orders ()
    	{
    		return $this->belongsToMany('Item','item_orders')->withPivot('quantity','id');
    	}

        public function grille ()
        {
            return $this->belongsTo('Grille');
        }
    }
