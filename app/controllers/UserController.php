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
            return Redirect::to('/checkout');  
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

            return View::make('users.edit')->with('user', $user);
        }

        //else, redirect to checkout page
        else
        {
            $user = User::where('cs50_id', $current_user['identity'])->get()[0];
            Session::put('user', $user);
            return Redirect::to('/checkout');
        }   
    }

    public function edit_test()
    {

        $user = new User();
        $user->cs50_id = 'testetstest';
        $user->name = "Ryan Wade Sandler";
        $user->preferred_name = "Ryan";
        $user->phone_number = "";
        $user->email = "SandlerRyan@gmail.com";
        $user-> save();
        return View::make('users.edit')->with('user', $user);
    }
 
    public function edit_user($id)
    {
        //check to make sure phone number in correct format
        $number = Input::get('phone_number');

        //took pattern from http://www.w3resource.com/javascript/form/phone-no-validation.php
        $pattern = "/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/"

        if preg_match ($pattern, $number) 
        {
        // Input doesn't return zero for unchecked boxes, so change these to zero
        $hours_notification = (Input::get('hours_notification') ? 1 : 0);
        $deals_notification = (Input::get('deals_notification') ? 1 : 0);
        //update table with user's preferred name and phone number
        DB::table('users')->where('id',$id)->update(array('preferred_name' => Input::get('preferred_name'),
                                                            'phone_number' => Input::get('phone_number'),
                                                            'hours_notification' => $hours_notification,
                                                            'deals_notification' => $deals_notification));
        Session::put('user', User::findorfail($id));
        // TODO: redirect to most recent page
        return Redirect::to('/checkout');    

        }
                                          
    }

    /* adds user's phone number to the database
    * called by ajax from the success page
    */
    public function add_phone($phone)
    {
        $user = Session::get('user');
        if (!$user){
            return Redirect::to('/checkout')->with('message','Could not add phone number. User not logged in');
        }
        $user_info = User::findorfail($user->id);
        $user_info->phone_number = $phone;
        $user_info->save();
        Session::put("user",$user_info);
        $response['status'] = 'success';
        return json_encode($response);
    }


}








