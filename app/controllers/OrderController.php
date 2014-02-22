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
            $items = Item::select('id','name','price','description','available')->
                where('category_id',$category->id)->get();
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return Redirect::to('courses/');
    }

    // Check Request form from the order page. 
    public function checkout()
    {   
        // if the user was not authenticated when storing the order, 
        // controller will return here and raise an error
        // SOMETHING MESSED UP HERE WITH SHOWING ERROR ON VIEW
        $err_messages = Session::get('message');

        // TODO: Check if user exists and is logged in. If he does, redirect to Checkout Page. 
        //If it doesn't exist, redirect to HUID, and then to Checkout Page.

        // if cart is not empty, get the total
        $total = Cart::total();
        if ($total == 0)
        {
            Redirect::to('/order/create/')->with('message', 'Cart empty--cannot proceed to checkout');
        }
        // TODO: more error checking on the exact value of items

        $this->layout->content = View::make('checkout.index');

    }

    /* Helper function to actually store the order to the database
    *  Called after user has successfully paid
    */
    private function store_order($reponse, $venmo=NULL)
    {
        if (!Auth::check())
        {
            // Raise some kind of error
            Redirect::to('/checkout')->with('message', 'You must login to complete checkout');
        }

        // create the new order
        $order = new Order();
        // CHECK BACK ON THIS after Ryan's CS50ID implementation!!
        $order->user_id = Auth::user()->id;
        $order->cost = Cart::total();
        $order->$venmo_id = $venmo;
        $order->fulfilled = 0;
        $order.save();

        // now add the ordered items to the item_orders join table
        $contents = Cart::contents();
        foreach ($contents as $item)
        {
            $item_order = new ItemOrder();
            $item_order->order_id = $order->id;
            $item_order->item_id = $item->id;
            $item_order.save();
        }
        // empty the cart
        Cart::destroy();
        Redirect::to('/success')->with('response',$response);
    }

       
    public function pay_later()
    {
        //User has decided to Pay Later.

        //TODO: Edit Order for Pay Later and send back Order ID
        $response = "You have decided to pay later.";
        store_order($response);

    }

    // accesses the venmo API so users can pay
    public function authenticatePayment() 
    {   

        //Get Access Token from Venmo Response
        $access_token = Input::get('access_token');

        // Create Payment and Charge the User
        $url = 'https://api.venmo.com/v1/payments';
        $data = array("access_token" => $access_token, "amount" => 0.01, 
            "phone" => "7734901404", "note" => "testing");
        $response = sendPostData($url, $data);

        // Store the order info in the database
        // store_order($response, $venmo_key=??)

    }

    //Show Success Page with appropiate message
    public function success($response) 
    {   

     $this->layout->content = View::make('checkout.success', ['response' => $response]);

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