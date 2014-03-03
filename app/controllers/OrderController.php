<?php

class OrderController extends \BaseController {
    protected $GRILLE_ID = 1;
    /**
     * Show the form for creating a new order.
     *
     * @return Response
     */
    public function create()
    {
        // fetch all available menu items by category
        $categories = Category::all();
        $menu = array();
        foreach ($categories as $category)
        {
            $items = Item::where('category_id', $category->id)->get();
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
    */
    public function checkout()
    {   
        require_once(app_path().'/config/id.php');
        // if the user was not authenticated when storing the order, 
        // controller will return here and raise an error
        // SOMETHING MESSED UP HERE WITH SHOWING ERROR ON VIEW

        $err_messages = Session::get('message');

        $errors = Session::get('message');

        // if cart is not empty, get the total
        $total = Cart::total_with_addons();
        if ($total == 0)
        {
            return Redirect::to('/order/create/')->with('message', 
                'Cart empty. Cannot proceed to checkout');
        }

        // TODO: more error checking on the exact value of items
        $this->layout->content = View::make('checkout.index', ['err_messages' => $errors, 'user'=>Session::get('user')]);
    }

    //Function to Make POST Requests with Data  
    protected function sendPostData($url, $post)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($post));
        return curl_exec($ch);
    }

    //User has decided to Pay Later.
    public function pay_later()
    {
        //TODO: Edit Order for Pay Later and send back Order ID
        
        $response_array['status'] = 'later';
        $response_array['message'] = "You have decided to pay later.";

        return Redirect::to('/success')->with('response',$response_array);
    }

    // accesses the venmo API so users can pay
    public function authenticatePayment() 
    {   
        //Get Access Token from Venmo Response
        $access_token = Input::get('access_token');

        // Create Payment and Charge the User
        $url = 'https://api.venmo.com/v1/payments';
        $data = array("access_token" => $access_token, "amount" => 0.01, 
            "phone" => "7734901404", "note" => "malan example");
        $response = $this->sendPostData($url, $data);

        $response_array['status'] = 'venmo';
        $response_array['message'] = $response;

        return Redirect::to('/success')->with('response',$response_array);

    }

    //Show Success Page with appropiate message
    public function success() 
    {   

        // make sure this was routed from the payment methods
        $response = Session::get('response');
        if (!$response){ 
            return Redirect::to('/checkout')->with('message','You must select a payment option.');
        }
        // make sure user is logged in
        if (!Session::has('user')) {
            // Raise some kind of error
            return Redirect::to('/checkout')->with('message', 'You must login to complete checkout');
        }

        if($response['status'] == "venmo") {
            //get the id
            $venmoJSON = json_decode($response['message'], true);
            $transaction = 0;
            if (array_key_exists('error', $venmoJSON)) {
                
                return Redirect::to('/checkout')->with('message', 'Venmo Payment Failed');

            } else {
                
                $transaction = $venmoJSON['data']['payment']['id'];
            }

        } else {
            $transaction = 0;
        }
        // create the new order
        $order = new Order();
        // CHECK BACK ON THIS after Ryan's CS50ID implementation!!
        $order->user_id = Session::get('user')->id;
        $order->grille_id = $this->GRILLE_ID;
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
        $order_id = $order->id;
        $user_id = Order::where('id', $order_id)->pluck('user_id');


        $name = User::where('id', $user_id)->pluck('preferred_name');
        //$phone = User::where('id', $user_id)->pluck('phone_number');
        $phone = "7734901404";
        $num_orders = Order::where('fulfilled', 0)->where('id', '!=', $order_id)
                                                ->count();
        $message = "Hi " . $name . ", your order has been received! There are currently " .
                    $num_orders . " orders in front of you. See you soon!";

        send_sms($phone,$message);

        $this->layout->content = View::make('checkout.success', ['response' => $response['status'], 
            'order' => $order_info]);
    }

}

function send_sms($phone, $message)
{
        // this line loads the library 

        require(app_path().'/config/twilio-php/Services/Twilio.php');
         
        $account_sid = 'AC08031ad462de058a85cfebfbf5be5331';
        $auth_token = '9b04babfc8f329f90f4f432926eaa007';
        $client = new Services_Twilio($account_sid, $auth_token); 
         
        $client->account->messages->create(array( 
            'To' => $phone, 
            'From' => "+18432716240", 
            'Body' => $message,
        ));

}

