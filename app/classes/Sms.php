<?php

class Sms
{
    static public function send_sms($phone, $message)
    {
        // this line loads the library
        require(app_path().'/config/twilio-php/Services/Twilio.php');

        $account_sid = 'AC08031ad462de058a85cfebfbf5be5331';
        $auth_token = '9b04babfc8f329f90f4f432926eaa007';
        $client = new Services_Twilio($account_sid, $auth_token);

        $client->account->messages->create(array(
            'To' => $phone,
            'From' => "+18432716240",
            'Body' => $message,
        ));
    }
    static public function send_text_blast($message)
    {
        // this line loads the library
        require(app_path().'/config/twilio-php/Services/Twilio.php');

        $account_sid = 'AC08031ad462de058a85cfebfbf5be5331';
        $auth_token = '9b04babfc8f329f90f4f432926eaa007';
        $client = new Services_Twilio($account_sid, $auth_token);

        $client->account->messages->create(array(
            'To' => "7734901404",
            'From' => "+18432716240",
            'Body' => $message,
        ));
    }
}