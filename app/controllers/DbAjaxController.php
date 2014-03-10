<?php

class DbAjaxController extends \AdminBaseController {

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
        $note = "Your money for order " . $id . " has been refunded.";
        $data = array("access_token" => $access_token, "amount" => 0.04,
                "phone" => $phone_number, "note" => $note, "audience" => "private");
        $response = $this->sendPostData($url, $data);

        return 1;
    }

    public function toggle_open ()
    {
        $grille_id = 1;
        $grille = Grille::find($grille_id);
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

    public function get_orders($type)
    {
        switch ($type)
        {
            case 'new':
                $orders = Order::with('item_orders')->where('fulfilled', 0)->
                    where('cancelled', 0)->get();
                break;
            case 'fulfilled':
                $orders = Order::with('item_orders')->where('fulfilled', 1)->
                    where('cancelled', 0)->get();
                break;
            case 'cancelled':
                $orders = Order::with('item_orders')->where('fulfilled', 0)->
                    where('cancelled', 1)->get();
                break;
            default:
                return array('status' => 'error');
        }

        foreach($orders as $order){
            // add user info
            $order->user;
        }
        foreach($orders as $order){
          foreach($order->item_orders as $item){
            $item_addons = ItemOrder::find($item->pivot->id)->addons->toArray();
            $item['addons'] = $item_addons;
          }
        }
        $response_array['status'] = 'success';
        $response_array['cart'] =  json_decode($orders);
        return json_encode($response_array);
    }

    public function mark_as_cooked($id) {
        $order = Order::find($id);
        $order->cooked = 1;
        $order->save();
        //alert user that order is ready
        $name = User::where('id', $order->user_id)->pluck('preferred_name');
        $phone = User::where('id', $order->user_id)->pluck('phone_number');

        $message = "Hi " . $name . ", your order is ready! Come pick it up from the grille!";

        Sms::send_sms($phone, $message);

        return 1;
    }
    public function mark_as_fulfilled($id) {
        $order = Order::find($id);
        $order->fulfilled = 1;
        $order->save();

        // alert user that order is ready
        $name = User::where('id', $order->user_id)->pluck('preferred_name');
        $phone = User::where('id', $order->user_id)->pluck('phone_number');

        $message = "Hi " . $name . ", your order is closed! Enjoy the food!";

        Sms::send_sms($phone, $message);

        return 1;
    }

    public function refund_order($id) {
        $order = Order::find($id);
        // $response_array = array();

        if ($order->venmo_id != 0) {
            if ($this->refundCostViaVenmo($id) == 1) {
                // $response_array['status'] = 'error';
                // $response_array['message'] = 'Something went wrong';
                // $order->refunded = 0;
                // $order->save();
                return 1;
                // return 0;
            } else {
                // $order->refunded = 1;
                $order->fulfilled = 0;
                $order->save();
                return 0;
            }
        }
        return 1;
    }

    public function cancel($id) {
        $order = Order::find($id);
        $order->cancelled = 1;
        $order->save();

        // alert user their order has been cancelled
        $name = User::where('id', $order->user_id)->pluck('preferred_name');
        $phone = User::where('id', $order->user_id)->pluck('phone_number');

        $message = "Hi " . $name . ", something went wrong and your order (no. "
            . $order->id . ") has been cancelled. Sorry!";

        Sms::send_sms($phone, $message);

        return 1;
    }

    public function mark_as_unavailable($id) {
        $item = Item::find($id);
        $item->available = 0;
        $item->save();
        return json_encode($item);
    }

    public function mark_as_available($id) {
        $item = Item::find($id);
        $item->available = 1;
        $item->save();
        return json_encode($item);
    }
}


