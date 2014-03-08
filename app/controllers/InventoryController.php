<?php

class InventoryController extends \BaseController {

    public function index()
    {
    	$items = Inventory::all();
        $this->layout->content = View::make('inventory.index', ['items' => $items]);        
    }

}
