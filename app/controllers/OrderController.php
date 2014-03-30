<?php

class OrderController extends \BaseController {
    /**
     * Show the form for creating a new order.
     * @return Response
     */
    public function create()
    {
        // fetch all available menu items by category
        $categories = Category::where('grille_id', $this->grille_id)->get();
        $menu = array();
        foreach ($categories as $category)
        {
            $items = Item::where('category_id', $category->id)
                            ->where('grille_id', $this->grille_id)->get();
            $menu[$category['name']] = $items;
        }

        // get any errors sent from other functions
        $errors = Session::get('message');

        // now send to the view
        $this->layout->content = View::make('orders.create',
            ['menu' => $menu, 'err_messages' => $errors]);
    }


    /**
    * Displays checkout page with order summary and check is use is logged in
    * @return Response
    */
    public function checkout()
    {
        require_once(app_path().'/config/id.php');
        // if the user was not authenticated when storing the order,
        // controller will return here and raise an error
        // SOMETHING MESSED UP HERE WITH SHOWING ERROR ON VIEW
        $errors = Session::get('message');

        // validate that all items are still available
        foreach(Cart::contents() as $item){
            if(!Item::find($item->id)['available']){
                Cart::destroy();
                return Redirect::to('/order/create')->with('message',
                    'Sorry! An item has gone out of stock during your ordering process.
                    Please redo your order.');
            }

            // now check associated addons
            foreach($item->addons as $addon){
                if(!Addon::find($addon->id)['available']){
                    Cart::destroy();
                    return Redirect::to('/order/create')->with('message',
                        'Sorry! An item has gone out of stock during your ordering process.
                        Please redo your order.');
                }
            }
        }

        // if cart is not empty, get the total
        $total = Cart::total_with_addons();
        if ($total == 0)
        {
            return Redirect::to('/order/create/')->with('message',
                'Cart empty. Cannot proceed to checkout');
        }

        // TODO: more error checking on the exact value of items
        $this->layout->content = View::make('orders.checkout',
            ['err_messages' => $errors, 'user'=>Session::get('user')]);
    }


    /**
    * Big function that validates and stores each order in the db
    * and notifies user that the order has been successful
    * @return Response
    */
    public function success()
    {
        // make sure this was routed from the payment methods
        $response = Session::get('response');
        if (!$response){
            return Redirect::to('/order/checkout')->with('message','You must select a payment option.');
        }
        // make sure user is logged in
        if (!Session::has('user')) {
            // Raise some kind of error
            return Redirect::to('/order/checkout')->with('message', 'You must login to complete checkout');
        }

        if($response['status'] == "venmo") {
            //get the id
            $venmoJSON = json_decode($response['message'], true);
            $transaction = 0;
            if (array_key_exists('error', $venmoJSON)) {

                return Redirect::to('/order/checkout')->with('message', 'Venmo Payment Failed');

            } else {

                $transaction = $venmoJSON['data']['payment']['id'];
                $response['status'] = "You have successfully paid via Venmo.";
            }

        }
        else {
            $transaction = 0;
            $response['status'] = "You have chosen to pay at Grille. You will receive a text when your order is ready";

        }
        // create the new order
        $order = new Order();
        $order->user_id = Session::get('user')->id;
        $order->grille_id = $this->grille_id;
        $order->cost = Cart::total_with_addons();
        $order->venmo_id = $transaction;
        $order->fulfilled = 0;
        $order->save();

        // now add the ordered items to the item_orders join table
        $contents = Cart::contents();
        foreach ($contents as $item)
        {
            $item_order = new ItemOrder();
            $item_order->order_id = $order->id;
            $item_order->item_id = $item->id;
            $item_order->quantity = $item->quantity;
            $item_order->notes = $item->notes;
            $item_order->save();

            // get the addons and save them to addon_item_orders join table
            foreach($item->addons as $addon)
            {
                $addon_order = new AddonItemOrder();
                $addon_order->item_order_id = $item_order->id;
                $addon_order->addon_id = $addon->id;
                $addon_order->quantity = $addon->quantity;
                $addon_order->save();
            }

        }

        // put all the order info into one nice object to pass to the view
        $order_info = Order::with('item_orders')->find($order->id);

        // empty the cart
        Cart::destroy();

        //send a text message to user to tell them how many orders in front of them
        $user_id = Order::where('id', $order->id)->pluck('user_id');
        $name = User::where('id', $user_id)->pluck('preferred_name');
        $phone = User::where('id', $user_id)->pluck('phone_number');
        // $phone = "6159183416";  // hardcoded to ryan's number for now
        $num_orders = Order::where('fulfilled', 0)->where('id', '!=', $order->id)
                        ->where('cancelled', 0)->count();
        if ($num_orders == 1) {
            $message = "Hi " . $name . ", your order with " . $order->grille->name .
                " has been received! Your order number is " . $order->id . ". There is currently " .
                $num_orders . " order in front of you. See you soon!";
        }
        else {
            $message = "Hi " . $name . ", your order with " . $order->grille->name .
                " has been received! Your order number is " . $order->id . ". There are currently " .
                $num_orders . " orders in front of you. See you soon!";
        }
        Sms::send_sms($phone,$message);

        $this->layout->content = View::make('orders.success', ['response' => $response['status'],
            'order' => $order_info]);
    }

}


