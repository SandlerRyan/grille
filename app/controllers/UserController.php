<?php

class UserController extends \BaseController {
    //Check if user already logged in
    public function login()
    {
        require_once(app_path().'/config/id.php');
        // if user is already logged in, redirect to index.php
        if (Session::has('user'))
        {
            // TODO: redirect to most recent page
            return Redirect::to('/order/checkout');
        }

        // else redirect user to CS50 ID
        else
            return Redirect::to(CS50::getLoginUrl(TRUST_ROOT, RETURN_TO));
    }

    public function logout()
    {

        require_once(app_path().'/config/id.php');

        if (Session::has('user'))
            Session::forget('user');
        Auth::logout();
        return Redirect::to('/');
    }

    public function return_to()
    {
        // configuration
        require_once(app_path().'/config/id.php');

        // remember which user, if any, logged in
        $current_user = CS50::getUser(RETURN_TO);

        //check if returning user
        $input = array('cs50_id' => $current_user["identity"]);
        $rules = array('cs50_id' => 'exists:users,cs50_id');

        $validator = Validator::make($input, $rules);

        //if doesn't exist, take user to edit page
        if ($validator->fails())
        {
            //parse first name
            $full = $current_user["fullname"];
            $split = explode(' ',trim($full));
            $first = $split[0];

            $user = new User();
            $user->cs50_id = $current_user["identity"];
            $user->name = $current_user["fullname"];
            $user->preferred_name = $first;
            $user->phone_number = "";
            $user->email = $current_user["email"];
            $user-> save();

            $failure = Session::get('failure');
            $this->layout->content = View::make('users.edit', ['user' => $user, 'failure' => $failure]);
        }

        //else, redirect to checkout page
        else
        {
            $user = User::where('cs50_id', $current_user['identity'])->get()[0];
            Session::put('user', $user);
            Auth::loginUsingId($user->id);
            return Redirect::to('/order/checkout');
        }
    }

    public function edit_user($id)
    {
        //check to make sure phone number in correct format
        $number = Input::get('phone_number');

        //took pattern from http://www.w3resource.com/javascript/form/phone-no-validation.php
        $pattern = "/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/";

        if (preg_match ($pattern, $number))
        {
            // Input doesn't return zero for unchecked boxes, so change these to zero
            $hours_notification = (Input::get('hours_notification') ? 1 : 0);
            $deals_notification = (Input::get('deals_notification') ? 1 : 0);

            //strip any punctuation from phone number, if exists
            $phone = str_replace(array("-","."), "", Input::get('phone_number'));

            //update table with user's preferred name and phone number
            DB::table('users')->where('id',$id)->update(array('preferred_name' => Input::get('preferred_name'),
                                                                'phone_number' => $phone,
                                                                'hours_notification' => $hours_notification,
                                                                'deals_notification' => $deals_notification));
            Session::put('user', User::findorfail($id));
            // TODO: redirect to most recent page
            return Redirect::to('/order/checkout');
        }
        else
        {
            $failure = 'Please enter a 10-digit phone number';
            return Redirect::to('/user/return_to')->with('failure', $failure);
        }

    }


    /* adds user's phone number to the database
    * called by ajax from the success page
    */
    public function add_phone($phone)
    {
        $user = Session::get('user');
        if (!$user){
            return Redirect::to('/order/checkout')->with('message','Could not add phone number. User not logged in');
        }
        $user_info = User::findorfail($user->id);
        $user_info->phone_number = $phone;
        $user_info->save();
        Session::put("user",$user_info);
        $response['status'] = 'success';
        return json_encode($response);
    }


}








