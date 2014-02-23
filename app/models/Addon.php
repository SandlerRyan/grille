<?php

    class Addon extends Eloquent 
    {
        public $timestamps = false;

    	public function grille ()
    	{
    		return $this->belongsTo('Grille');
    	}

    	public function item ()
    	{
    		return $this->belongsToMany('Item','addon_items');
    	}

    }
