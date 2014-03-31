<?php

class InventoryController extends \DashboardController {

    /**
    * Display all the inventory items
    * @return Response
    */
    public function index()
    {
    	$items = Inventory::where('grille_id', $this->grille_id)->get();
        $this->layout->content = View::make('inventory.index', ['items' => $items]);
    }

    /**
    * Increment the quantity of an inventory item
    * Called by ajax when "+" sign is pressed
    * @param $id                    id of the item to be added
    * @return $response_array       json object with status and any additional data
    */
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
    * @param $id    id of the item to be decremented
    * @return $response_array       json object with status and any additional data
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
