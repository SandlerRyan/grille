<?php

    class Hour extends Eloquent 
    {
    	public $timestamps = false;
    	
    	public function grille ()
    	{
    		return $this->belongsTo('Grille');
    	}
    }
