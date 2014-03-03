<?php

class InventoryController extends \BaseController {

    public function show() 
    {
        $this->layout->content = View::make('inventory.index');        
    }

}
