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

        // now send to the view
        $this->layout->content = View::make('orders.create', 
            ['menu' => $menu, 'categories' => $categories]);
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

    //Check if user already logged in
    public function login()
    {
        require_once(app_path().'/config/id.php');
        // if user is already logged in, redirect to index.php
        if (Session::has('user'))
        {
            //$protocol = (Request::secure()) ? "https" : "http";
            //$host  = Request::server("HTTP_HOST");
            //$path = rtrim(dirname(Request::server("PHP_SELF")), "/\\");
            //return Redirect::to('{$protocol}://{$host}{$path}.php');
            return Redirect::to('/checkout');  
        }

        // else redirect user to CS50 ID
        else
            return Redirect::to(CS50::getLoginUrl(TRUST_ROOT, RETURN_TO));
    }

    public function logout()
    {

        require_once(app_path().'/config/id.php');

        if (Session::has('user'))
            Session::forget('user');
    
        // redirect user to checkout
        //$protocol = (Request::secure()) ? "https" : "http";
        //$host  = Request::server("HTTP_HOST");
        //$path = rtrim(dirname(Request::server("PHP_SELF")), "/\\");
        //return Redirect::to('{$protocol}://{$host}{$path}.php');
        return Redirect::to('/checkout');  
    }

    public function return_to()
    {

        // configuration
        require_once(app_path().'/config/id.php');

        // remember which user, if any, logged in
        $user = CS50::getUser(RETURN_TO);
        if ($user !== false)
            //$_SESSION["user"] = $user;
            Session::put("user", $user);
       
        // redirect user to index.php
        //$protocol = (Request::secure()) ? "https" : "http";
        //$host  = Request::server("HTTP_HOST");
        //$path = rtrim(dirname(Request::server("PHP_SELF")), "/\\");

        //return Redirect::to('{$protocol}://{$host}{$path}.php');
        return Redirect::to('/checkout');
    }
    //Check Request form from the order page. 
    public function checkout()
    {   
        require_once(app_path().'/config/id.php');
        // TODO: Check if user exists. If it does, redirect to Checkout Page. 
        //If it doesn't exist, redirect to HUID, and then to Checkout Page.

        //$identity = $_SESSION["user"]["identity"];
        //$fullname = $_SESSION["user"]["fullname"];
        //$email = $_SESSION["user"]["email"];
        //$isset = isset($_SESSION["user"]);

        // if cart is not empty, get the total
        $total = Cart::total();
        
        //check if user logged in
        if (Session::has('user'))
        {
            $loggedin = True;
        }
        else 
            $loggedin = False;

        $this->layout->content = View::make('checkout.index', ['loggedin' => $loggedin]);

    }


    public function pay_later()
    {
        //User has decided to Pay Later.

        //TODO: Edit Order for Pay Later and send back Order ID
        $response = "You have decided to pay later.";
        return Redirect::to('/success')->with('response', $response);

    }

    // accesses the venmo API so users can pay
    public function authenticatePayment() 
    {   

        //Get Access Token from Venmo Response
        $access_token = Input::get('access_token');

        //Create Payment and Charge the User
        $url = 'https://api.venmo.com/v1/payments';
        $data = array("access_token" => $access_token, "amount" => 0.01, 
            "phone" => "7734901404", "note" => "testing");
        $response = sendPostData($url, $data);
        
        //Redirect to Success Page and show Order ID and Status 
        return Redirect::to('/success')->with('response', $response);

    }

    //Show Success Page with appropiate message
    public function success() 
    {   

     $response = Session::get('response');
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