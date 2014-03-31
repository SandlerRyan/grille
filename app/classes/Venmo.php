<?php

// Class for handling all operations with Venmo API
class Venmo
{
	// url to the venmo api
	const PAYMENTS_URL = 'https://api.venmo.com/v1/payments';

	// url to venmo user authentication pop-up
	const AUTHENTICATION_URL =
		'https://api.venmo.com/v1/oauth/authorize?client_id=1322&scope=make_payments%20access_profile&response_type=token';

    /**
    * Necessary for sending requests to venmo api
    * @param $url        the url for the venmo payments api
    * @param $
    */
    static protected function send_post_data($data)
    {
        $ch = curl_init(self::PAYMENTS_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        return curl_exec($ch);
    }

    /**
    * Venmo API redirects here so users can pay
    */
    static public function authenticate_payment()
    {
        // Get Access Token from Venmo Response
        $access_token = Input::get('access_token');
        // $phone_number = Session::get('user')->phone_number;
        // Create Payment and Charge the User
        $url = 'https://api.venmo.com/v1/payments';
        // randomized so each note is different
        $amt = ((float) rand(1,5)) / 100.;
        $note = date('m/d/Y h:i:s a', time());

        $data = array("access_token" => $access_token, "amount" => $amt,
            "phone" => "7734901404", "note" => $note);
        $response = self::send_post_data($data);

        $response_array['status'] = 'venmo';
        $response_array['message'] = $response;

        return Redirect::to('/order/success')->with('response',$response_array);
    }

    /**
    * Makes a request to venmo to refund the given order
    * called by refund_order
    * @param $id    order id to be refunded
    */
    static public function refund_cost($id, $phone_number)
    {
        // This function uses the Grille App access token to pay the phone number
        //of the user that placed the order.
        $access_token = "waMg5yEHQZZUHvcdJbyqAWCJTxgZR8eD";
                $note = "Your money for order " . $id . " has been refunded.";
        $data = array("access_token" => $access_token, "amount" => 0.04,
                "phone" => $phone_number, "note" => $note, "audience" => "private");
        $response = self::send_post_data($data);

        return 1;
    }
}