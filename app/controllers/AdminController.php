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

        //alert user that order has been refunded
        //TODO - give a reason? next steps?
        $name = User::where('id', $order->user_id)->pluck('preferred_name');
        $phone = User::where('id', $order->user_id)->pluck('phone_number');

        $message = "Hi " . $name . ", Unfortunately, something went wrong with your order. 
                    We have refunded you completely.";

        return Redirect::action('OrderController@send_sms', array('phone' => $phone, 'message' => $message));


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

        //alert user that order is ready
        $name = User::where('id', $order->user_id)->pluck('preferred_name');
        $phone = User::where('id', $order->user_id)->pluck('phone_number');

        $message = "Hi " . $name . ", your order is ready! Come pick it up from the grille!";

        return Redirect::action('OrderController@send_sms', array('phone' => $phone, 'message' => $message));

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

    //broadcast text message to all subscribers about special deals
    public function alert_deals ($message) {

        //select all users who are subscribed to deal alerts
        $users = User::where('deals_notification', 1)->get();

        foreach($users as $user){
            $phone = $user->phone_number;
            return Redirect::action('OrderController@send_sms', array('phone' => $phone, 'message' => $message));
        }
    }

    public function alert_hours ($message) {

        //select all users who are subscribed to hours alerts
        $users = User::where('hours_notification', 1)->get();

        foreach($users as $user){
            $phone = $user->phone_number;
            return Redirect::action('OrderController@send_sms', array('phone' => $phone, 'message' => $message));
        }
    }


}
function refundCostViaVenmo($id) {
    //TODO: Send Venmo Payment to the User Phone Number via Venmo Access Token for the Grille
    return 1;
}
