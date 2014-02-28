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
    public function refund_order($id) {
        $order = Order::find($id);
        if ($order->venmo_id != 0) {

            if (refundCostViaVenmo($id) != 1) {
                return 0;
            }

            $order->fulfilled = 2;
            $order->save();
        } else {
            //Cancel order entirely and mark it as 2 (cancelled)
            $order->fulfilled = 2;
            $order->save();
        }
        return 1;

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
function refundCostViaVenmo($id) {
    //TODO: Send Venmo Payment to the User Phone Number via Venmo Access Token for the Grille
    return 1;
}
