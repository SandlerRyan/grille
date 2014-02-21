<?php

    class Addon extends Eloquent 
    {
    	public function grille ()
    	{
    		return $this->belongsTo('Grille');
    	}

    	public function addon_items ()
    	{
    		return $this->belongsToMany('Item','addon_items');
    	}

    }
