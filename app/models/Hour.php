<?php

    class Hour extends Eloquent 
    {
    	public function grille ()
    	{
    		return $this->belongsTo('Grille');
    	}
    }
