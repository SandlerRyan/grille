<?php

// Class for handling Twilio-based SMS functions
class Sms
{
    /**
    * Generalized function for sending a text message to a given phone number
    * @param $message    the text body of the message to be sent
    * @return void
    */
    static public function send_sms($phone, $message)
    {
        // this line loads the library
        require(app_path().'/config/twilio-php/Services/Twilio.php');

        $account_sid = 'AC08031ad462de058a85cfebfbf5be5331';
        $auth_token = '9b04babfc8f329f90f4f432926eaa007';
        $client = new Services_Twilio($account_sid, $auth_token);


        try {
            $client->account->messages->create(array(
                'To' => $phone,
                'From' => "+18432716240",
                'Body' => $message,
            ));
        } catch (Services_Twilio_RestException $e) {
            return $e->getStatus();
        }
    }


}