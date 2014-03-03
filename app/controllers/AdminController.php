<?php

class AdminController extends \BaseController {

    
    public function dashboard() {
        // $orders = Order::where('fulfilled', 0)->get();
        $orders = Order::with('item_orders')->where('fulfilled', 0)->get();
        //  with('item_orders')->get();

        $items = Item::where('grille_id', 1)->get();

        $this->layout->content = View::make('admin.dashboard', ['orders' => $orders, 'items' => $items]);

    }
    public function filled_orders() {
        $orders = Order::with('item_orders')->where('fulfilled', '!=', 1)->get();
        foreach($orders as $order){
            $order->user;
        }
        $this->layout->content = View::make('admin.filled', ['orders' => $orders]);

    }
    public function inventory() {
        $this->layout->content = View::make('admin.inventory');        
    }


    protected function sendPostData($url, $post)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($post));
        return curl_exec($ch);
    }
    protected function refundCostViaVenmo($id) {

        // This function uses the Grille App access token to pay the phone number
        //of the user that placed the order. 
        $url = 'https://api.venmo.com/v1/payments';
        $access_token = "waMg5yEHQZZUHvcdJbyqAWCJTxgZR8eD";
        $order = Order::find($id);
        $phone_number = $order->user->phone_number;
        $data = array("access_token" => $access_token, "amount" => 0.01, 
                "phone" => $phone_number, "note" => "Testing Eliot Grille");
        $response = $this->sendPostData($url, $data);
        
        $venmoJSON = json_decode($response['message'], true);
        if (array_key_exists('error', $venmoJSON)) 
        {
            return 0;
        } else 
        {
            return 1;    
        }   

    }
    public function refund_order($id) {
        $order = Order::find($id);
        if ($order->venmo_id != 0) {

            if ($this->refundCostViaVenmo($id) != 1) {
                $order->refunded = 1;
                $order->save();
                return 0;
            } else {
                $order->refunded = 1;
                $order->fulfilled = 2;
                $order->save();    
                return 1;
            }
        } 
        return 0;

    }

    public function get_new_orders() {
        $orders = Order::with('item_orders')->where('fulfilled', 0)->get();
        foreach($orders as $order){
            $order->user;
        }
        // return json_encode($orders);
        $response_array['status'] = 'success';    
        $response_array['cart'] =  json_decode($orders);    

        return json_encode($response_array);
        // return $response_array;

    }

    public function mark_as_fulfilled($id) {
        $order = Order::find($id);
        $order->fulfilled = 1;
        $order->save();

        return 1;
    }
    public function mark_as_unavailable($id) {
        $item = Item::find($id);
        $item->available = 0;
        $item->save();
        return 1;
    }
    public function mark_as_available($id) {
        $item = Item::find($id);
        $item->available = 1;
        $item->save();
        return 1;
    }
    /**
     * Show the form for creating a new order.
     *
     * @return Response
     */



}

