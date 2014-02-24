<?php

class OrderController extends \BaseController {

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
        $item['type'] = 'item';
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

    /**
    * Displays checkout page with order summary and check is use is logged in
    */
    public function checkout()
    {   
        require_once(app_path().'/config/id.php');
        // if the user was not authenticated when storing the order, 
        // controller will return here and raise an error
        // SOMETHING MESSED UP HERE WITH SHOWING ERROR ON VIEW
        $errors = Session::get('message');

        // if cart is not empty, get the total
        $total = Cart::total();
        if ($total == 0)
        {
            return Redirect::to('/order/create/')->with('message', 
                'Cart empty. Cannot proceed to checkout');
        }

        // TODO: more error checking on the exact value of items
        $this->layout->content = View::make('checkout.index', ['err_messages' => $errors, 'user'=>Session::get('user')]);
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
            "phone" => "7734901404", "note" => "grille!");
        $response = sendPostData($url, $data);

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
            $venmoJSON = json_decode($response['message']);
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
        $order->cost = Cart::total();
        $order->venmo_id = $transaction;
        $order->fulfilled = 0;
        $order->save();

        // now add the ordered items to the item_orders join table
        $contents = Cart::contents();
        foreach ($contents as $item)
        {
            $item_order = new   ItemOrder();
            $item_order->order_id = $order->id;
            $item_order->item_id = $item->id;
            $item_order->quantity = $item->quantity;
            $item_order->notes = $item->notes;
            $item_order->save();

        }
        // empty the cart
        Cart::destroy();
        $this->layout->content = View::make('checkout.success', ['response' => $response['status']]);
    }
 
}

//Function to Make POST Requests with Data  
function sendPostData($url, $post)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($post));
    return curl_exec($ch);
}