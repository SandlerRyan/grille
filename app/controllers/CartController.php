<?php

class CartController extends \BaseController {

   /**
    * Increment the quantity of a cart item,
    * or add it if not yet in cart
    * Called by ajax when "+" sign is pressed
    */
    public function increment($id)
    {
        
        $item = Item::findOrFail($id);
        // add necessary fields
        $item['quantity'] = 1;
        $item['notes'] = "";
        $item['addons'] = array();
        //turn json into a php array
        $item = json_decode($item,true);
        // insert will add a new item if not already in cart, 
        // or increment item if it exists already
        Cart::insert($item);

        $total = Cart::total();
        $response_array['status'] = 'success';    
        $response_array['cart'] = number_format(Cart::total(), 2);    
        return json_encode($response_array);

    }

    /**
    * Decrement the quantity of a cart item,
    * or remove it if only 1 left
    * Called by ajax when "-" sign is pressed
    */
    public function decrement($id)
    {
        $item = Cart::find($id);
        // check if item exists; if quantity is already zero, do nothing
        if ($item)
            //if quantity is 1, remove item
            if ($item->quantity == 1)
            {
                Cart::remove($item->identifier);
            }
            else
            {
                $item->quantity -- ;
            }
        $response_array['status'] = 'success';      
        $response_array['cart'] = number_format(Cart::total(), 2);    
        return json_encode($response_array);
    }

    /**
    * Increment an addon when the user presses the plus button on the order page
    * called by ajax
    */
    public function increment_addon()
    {

    }

    /**
    * Decrement or remove an addon when user presses the minus button on order page
    * called by ajax
    */
    public function decrement_addon()
    {

    }

    /**
    * Empty the shopping cart when user presses "clear"
    * Called by ajax
    */
    public function empty_cart()
    {
        Cart::destroy();
        $response_array['status'] = 'success';      
        $response_array['cart'] = number_format(Cart::total(), 2);    
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




