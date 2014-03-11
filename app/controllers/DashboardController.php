<?php

class DashboardController extends \AdminBaseController {


    public function dashboard() {

        // $orders = Order::where('fulfilled', 0)->get();
        $orders = Order::with('item_orders')->where('fulfilled', '=', 0)
            ->where('cancelled', '=', 0)->orderBy('created_at', 'desc')->get();

        $items = Item::where('grille_id', 1)->get();

        $this->layout->content = View::make('dashboard.index', ['orders' => $orders, 'items' => $items]);

    }

    public function filled_orders() {
        $orders = Order::with('item_orders')->where('fulfilled', '=', 1)
            ->orderBy('created_at', 'desc')->get();
        foreach($orders as $order){
            $order->user;
        }
        $this->layout->content = View::make('dashboard.filled', ['orders' => $orders]);

    }

    public function cancelled_orders() {
        $orders = Order::with('item_orders')->where('cancelled', '=', 1)
            ->orderBy('created_at', 'desc')->get();
        foreach($orders as $order){
            $order->user;
        }
        $this->layout->content = View::make('dashboard.cancelled', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a text alert.
     *
     * @return Response
     */
    // todo

    // broadcast text message to all subscribers about special deals
    public function alert_deals ($message) {

        //select all users who are subscribed to deal alerts
        $users = User::where('deals_notification', 1)->get();

        foreach($users as $user){
            $phone = $user->phone_number;
            Sms::send_sms($phone, $message);
        }
    }

    public function alert_hours ($message) {

        // select all users who are subscribed to hours alerts
        $users = User::where('hours_notification', 1)->get();

        foreach($users as $user){
            $phone = $user->phone_number;
            Sms::send_sms($phone, $message);
        }
    }


}


