<?php

class InventoryController extends \BaseController {

    public function index()
    {
        $this->layout->content = View::make('inventory.index');
    }

}
