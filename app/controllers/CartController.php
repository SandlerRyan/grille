<?php

class CartController extends \BaseController {

   /**
    * Increment the quantity of a cart item,
    * or add it if not yet in cart
    * Called by ajax when "+" sign is pressed
    */
    public function increment($id)
    {
        $item = Item::find($id);
        $response_array = array();

        // add necessary fields
        $item['quantity'] = 1;
        $item['notes'] = "";
        $item['addons'] = array();
        //turn json into a php array
        $item = json_decode($item,true);

        // insert will add a new item if not already in cart,
        // or increment item if it exists already
        Cart::insert($item);

        $total = Cart::total_with_addons();
        $response_array['status'] = 'success';
        $response_array['cart'] = number_format(Cart::total_with_addons(), 2);
        return json_encode($response_array);
    }

    /**
    * Decrement the quantity of a cart item,
    * or remove it if only 1 left
    * Called by ajax when "-" sign is pressed
    */
    public function decrement($id)
    {
        $item = Cart::find($id);        // from cart in session
        $dbitem = Item::find($id);      // from db
        $response_array = array();
        // check if item exists; if quantity is already zero, do nothing
        if ($item)
        {
            // if quantity is 1, remove item
            if ($item->quantity == 1) {
                Cart::remove($item->identifier);
            }
            else
            {
                $item->quantity -- ;

                // check the item's addons to see if there are more than the number of items;
                // if so, decrement those addons
                foreach(Cart::get_addons($item) as $addon)
                {
                    if ($addon->quantity > $item->quantity) {
                        Cart::update_addon($addon->id, $item, 'quantity', $item->quantity);
                    }
                }
            }
        }
        $response_array['status'] = 'success';
        $response_array['cart'] = number_format(Cart::total_with_addons(), 2);
        return json_encode($response_array);
    }

    /**
    * Increment an addon when the user presses the plus button on the order page
    * called by ajax
    */
    public function increment_addon($addon_id, $item_id)
    {
        $item = Cart::find($item_id);           // from cart in session
        $addon = Addon::find($addon_id);        // from database
        $response_array = array();

        // if item doesn't exist, return success
        // but don't validate so nothing will change
        if (!$item) return json_encode(array('status' => 'success', 'validated' => 'false'));

        // add necessary fields
        $addon['quantity'] = 1;
        $addon['addons'] = array();
        $addon = json_decode($addon,true);

        // try inserting. If insertion returns false, there are too many addons
        // for the number of items. In this case, return false for validation
        $insertion = Cart::insert_addon($addon, $item);
        if (!$insertion){
            return json_encode(array('status' => 'success', 'validated' => 'false', 'available' => true));
        }
        $response_array['status'] = 'success';
        $response_array['validated'] = true;
        $response_array['cart'] = number_format(Cart::total_with_addons(), 2);
        return json_encode($response_array);
    }

    /**
    * Decrement or remove an addon when user presses the minus button on order page
    * called by ajax
    */
    public function decrement_addon($addon_id, $item_id)
    {
        $item = Cart::find($item_id);                       // cart object in session

        // check if item exists in cart and if associated addon exists; if not, do nothing
        if($item){
            $addon = Cart::find_addon($addon_id, $item);
            if($addon) {
                if($addon->quantity == 1)
                {
                    Cart::remove_addon($addon_id, $item);
                }
                else
                {
                    Cart::update_addon($addon_id, $item, 'quantity', --$addon->quantity);
                }
            }
        }
        $response_array['status'] = 'success';
        $response_array['cart'] = number_format(Cart::total_with_addons(), 2);
        return json_encode($response_array);
    }

    /**
    * Empty the shopping cart when user presses "clear"
    * Called by ajax
    */
    public function empty_cart()
    {
        Cart::destroy();
        $response_array['status'] = 'success';
        $response_array['cart'] = number_format(Cart::total_with_addons(), 2);
        return json_encode($response_array);
    }

    /**
    * Add to the session if user specifies anything from the checkout page
    * */
    public function add_note($id, $note)
    {
        $item = Cart::find($id);
        $item->notes = $note;
        $response_array['status'] = 'success';
        return json_encode($response_array);
    }

}




