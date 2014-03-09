<?php

class InventoryController extends \BaseController {

    public function index()
    {
    	$items = Inventory::all();
        $this->layout->content = View::make('inventory.index', ['items' => $items]);        
    }
    public function increment($id)
    {   
        $item = Inventory::find($id);
        $response_array = array();
        $item->quantity += 1;
        $item->save();
        $response_array['status'] = 'success';    
        $response_array['item'] = $item;
        return json_encode($response_array);
    }

    /**
    * Decrement the quantity of an inventory item,
    * Called by ajax when "-" sign is pressed on the inventory page
    */
    public function decrement($id)
    {
        $item = Inventory::find($id);   
        $response_array = array();
        //if quantity is already zero, do nothing
        if ($item->quantity > 0)
        {
            $item->quantity -= 1;
            $item->save();
        }   
        $response_array['status'] = 'success';      
        $response_array['item'] = $item;
        return json_encode($response_array);
    }

}
