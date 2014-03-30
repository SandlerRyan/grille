<?php

class DashboardController extends \BaseController {

    public function template() {
        View::make('test');
    }

    public function send_text_blast($message)
    {

        $this->alert_deals($message);
        return 1;
    }

    /**
    * Called by ajax to change the open status of the grille
    */
    public function toggle_open ()
    {
        $grille = Grille::find($this->grille_id);
        if ($grille->open_now) {
            $grille->open_now = 0;
            $grille->save();
        }
        else {
            $grille->open_now = 1;
            $grille->save();
        }
        return array('status' => 'success', 'open' => $grille->open_now);
    }

    /**
    * Server pings this function every 5000ms to request orders from the given template
    * @param $type               string enum indicating 'cancelled', 'fulfilled', or 'incoming' orders
    * @return $response_array    json object with all the data on the requested orders
    */
    public function get_orders($type)
    {
        switch ($type)
        {
            case 'new':
                $orders = Order::with('item_orders')->where('grille_id', $this->grille_id)
                                            ->where('fulfilled', 0)
                                            ->where('cancelled', 0)
                                            ->where('refunded', 0)
                                            ->orderBy('created_at', 'desc')
                                            ->get();
                break;
            case 'fulfilled':
                $orders = Order::with('item_orders')->where('grille_id', $this->grille_id)
                                            ->where('fulfilled', 1)
                                            ->where('refunded', 0)
                                            ->orderBy('created_at', 'desc')
                                            ->get();
                break;
            case 'cancelled':
                $orders = Order::with('item_orders')->where('grille_id', $this->grille_id)
                                            ->where('cancelled', 1)
                                            ->orderBy('created_at', 'desc')
                                            ->get();
                break;
            default:
                return array('status' => 'error');
        }

        foreach($orders as $order){
            // add user info
            $order->user;
        }

        date_default_timezone_set('America/New_York');
        foreach($orders as $order){
            // convert to a nicer datetime string
            $order['time'] = $order->created_at->format('M j \a\t g:i A');

            // get addons for each item
            foreach($order->item_orders as $item){
              $item_addons = ItemOrder::find($item->pivot->id)->addons->toArray();
              $item['addons'] = $item_addons;
            }
        }
        // some weird json decoding/encoding needed to get js scripts to parse correctly
        $response_array['status'] = 'success';
        $response_array['cart'] =  json_decode($orders);
        return json_encode($response_array);
    }

    /**
    * Called by ajax to mark an order as cooked
    * @param $id    the id of the order
    */
    public function mark_as_cooked($id)
    {
        $order = Order::find($id);
        $order->cooked = 1;
        $order->save();
        //alert user that order is ready
        $name = User::where('id', $order->user_id)->pluck('preferred_name');
        $phone = User::where('id', $order->user_id)->pluck('phone_number');

        $message = "Hi " . $name . ", your order with " . $order->grille->name .
            " is ready! Come pick it up from the grille!";

        Sms::send_sms($phone, $message);

        return 1;
    }

    /**
    * Called by ajax to mark an order as fulfilled
    * @param $id    the id of the order
    */
    public function mark_as_fulfilled($id) {
        $order = Order::find($id);
        $order->fulfilled = 1;
        $order->save();

        // alert user that order is ready
        $name = User::where('id', $order->user_id)->pluck('preferred_name');
        $phone = User::where('id', $order->user_id)->pluck('phone_number');

        $message = "Hi " . $name . ", your order with " . $order->grille->name .
            " is closed! Enjoy the food!";

        Sms::send_sms($phone, $message);

        return 1;
    }

    /**
    * Called by ajax to mark an order as cancelled
    * @param $id    the id of the order
    */
    public function cancel($id) {
        $order = Order::find($id);
        $order->cancelled = 1;
        $order->save();

        // alert user their order has been cancelled
        $name = User::where('id', $order->user_id)->pluck('preferred_name');
        $phone = User::where('id', $order->user_id)->pluck('phone_number');

        $message = "Hi " . $name . ", something went wrong and your order (no. "
            . $order->id . ") with " . $order->grille->name . " has been cancelled. Sorry!";

        Sms::send_sms($phone, $message);

        return 1;
    }

    /**
    * Called by ajax to refund an order by venmo
    * @param $id    the id of the order
    */
    public function refund_order($id)
    {
        $order = Order::find($id);
        $phone_number = $order->user->phone_number;

        // check that order was actually paid for with venmo
        if ($order->venmo_id == 0) {
            return json_encode(array('status' => 'error', 'messages' => 'Not paid with Venmo'));
        }

        // check that the order has not been refunded yet
        if ($order->refunded == 1) {
            return json_encode(array('status' => 'error', 'messages' => 'Already refunded'));
        }

        Venmo::refund_cost($id, $phone_number);
        $order->refunded = 1;
        $order->cancelled = 1;
        $order->save();

        //send user text alert
        $note = "Your money for order " . $id . " from the grille has been refunded.";
        Sms::send_sms($phone_number, $note);
        return json_encode(array('status' => 'success'));
    }

    /**
    * Called by ajax to mark an order as cooked
    * @param $id    the id of the order
    */
    public function mark_as_unavailable($id) {
        $item = Item::find($id);
        $item->available = 0;
        $item->save();
        return json_encode($item);
    }

    /**
    * Called by ajax to mark an order as cooked
    * @param $id    the id of the order
    */
    public function mark_as_available($id) {
        $item = Item::find($id);
        $item->available = 1;
        $item->save();
        return json_encode($item);
    }

    /**
    * broadcast text message to all subscribers about special deals
    * @param $message     the text body of the message to be sent
    */
    public function alert_deals ($message) {

        //select all users who are subscribed to deal alerts
        $users = User::where('deals_notification', 1)->get();

        foreach($users as $user){
            $phone = $user->phone_number;
            Sms::send_sms($phone, $message);
        }
    }

    /**
    * broadcast text message to all subscribers that grille is open or closed
    * at an unusual hour
    * @param $message      the text body of the message to be sent
    */
    public function alert_hours ($message) {

        // select all users who are subscribed to hours alerts
        $users = User::where('hours_notification', 1)->get();

        foreach($users as $user){
            $phone = $user->phone_number;
            Sms::send_sms($phone, $message);
        }
    }

}


