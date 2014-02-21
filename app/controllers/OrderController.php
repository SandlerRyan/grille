<?php

class OrderController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $courses = Order::get();
        $this->layout->content = View::make('orders.index', ['courses' => $courses]);

    }

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
        $this->layout->content = View::make('orders.create', ['menu' => $menu, 'categories' => $categories]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        
        return Redirect::to('courses/' . $course->id);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $this->layout->content = View::make('courses/edit', ["course" => $course]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        return Redirect::to('courses/' . $course->id);
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

    //Check Request form from the order page. 
    public function checkout()
    {   

        // TODO: Check if user exists. If it does, redirect to Checkout Page. 
        //If it doesn't exist, redirect to HUID, and then to Checkout Page.

        //Form Data
        $form = Input::all();

        $this->layout->content = View::make('checkout.index', ['form' => $form]);

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
        $data = array("access_token" => $access_token, "amount" => 0.01, "phone" => "7734901404", "note" => "testing");
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