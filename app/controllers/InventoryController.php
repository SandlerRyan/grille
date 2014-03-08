<?php

class InventoryController extends \BaseController {

    public function show() 
    {

    	$items = Inventory::all();
        $this->layout->content = View::make('inventory.index', ['items' => $items]);        
    }

}
