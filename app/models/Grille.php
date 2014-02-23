<?php

    class Grille extends Eloquent 
    {
    	public function manager ()
    	{
    		return $this->belongsTo('User');
    	}

    	public function hours ()
    	{
    		return $this->hasMany('Hour');
    	}

    	public function items ()
    	{
    		return $this->hasMany('Item');
    	}

    	public function addons ()
    	{
    		return $this->hasMany('Addon');
    	}
    }
