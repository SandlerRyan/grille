<?php

class UserController extends \BaseController {

    /**
    * Logs the user in or redirects to account creation if user's HUID
    * is not in the db
    * @return Response
    */
    public function login()
    {
        require_once(app_path().'/config/id.php');

        // if user is already logged in, redirect to current page
        if (Session::has('user'))
        {
            try {
                return Redirect::back();
            }
            catch (Exception $e) {
                return Redirect::to('/');
            }
        }

        // else redirect user to CS50 ID
        else
        {
            //store url in session
            Session::put('redirect', URL::previous());

            return Redirect::to(CS50::getLoginUrl(TRUST_ROOT, RETURN_TO));
        }
    }

    /**
    * Logs the user out
    * @return Response
    */
    public function logout()
    {

        require_once(app_path().'/config/id.php');

        if (Session::has('user'))
            Session::forget('user');
        Auth::logout();

        try {
            return Redirect::back();
        }
        catch (Exception $e) {
            return Redirect::to('/');
        }
    }

    /**
    * Gets input from the user editing form to get additional information
    * like phone number, preferred name, etc.
    * @return Response
    */
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

            $user = array("cs50_id"=> $current_user["identity"],
                            "fullname" => $current_user["fullname"],
                            "preferred_name" => $first,
                            "email" => $current_user["email"],
                            "new" => 1);


            //put user in the session
            Session::put('pending_user', $user);

            $failure = Session::get('failure');
            $this->layout->content = View::make('users.edit', ['user' => $user, 'failure' => $failure]);
        }

        //else, redirect to intended page
        else
        {
            $user = User::where('cs50_id', $current_user['identity'])->get()[0];
            Session::put('user', $user);
            Auth::loginUsingId($user->id);

            $url = Session::get('redirect');
            Session::forget('redirect');
            return Redirect::to($url);
        }
    }

    /**
    * Return_to redirects here to finalize gather of user information
    * and save the new user in the db
    * @return Response
    */
    public function edit_user()
    {
        //make sure user logged in or pending
        if (Session::has('user') || Session::has('pending_user'))
        {
            //check to make sure phone number in correct format
            $number = Input::get('phone_number');

            //took pattern from http://www.w3resource.com/javascript/form/phone-no-validation.php
            $pattern = "/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/";

            //if phone entered correctly
            if (preg_match ($pattern, $number))
            {

                // Input doesn't return zero for unchecked boxes, so change these to zero
                $hours_notification = (Input::get('hours_notification') ? 1 : 0);
                $deals_notification = (Input::get('deals_notification') ? 1 : 0);

                //strip any punctuation from phone number, if exists
                $phone = str_replace(array("-",".","(",")"," "), "", Input::get('phone_number'));

                //if user already logged in
                if (Session::has('user'))
                {
                    $user_session = Session::get('user');
                    $user = User::find($user_session->id);
                    $user->preferred_name = Input::get('preferred_name');
                    $user->phone_number = $phone;
                    $user->hours_notification = $hours_notification;
                    $user->deals_notification = $deals_notification;
                    $user->save();

                }
                //else create new user
                else
                {
                    //create user based on session data and input
                    $pending = Session::get('pending_user');

                    $user = new User();
                    $user->cs50_id = $pending["cs50_id"];
                    $user->name = $pending["fullname"];
                    $user->preferred_name = Input::get('preferred_name');
                    $user->email = $pending["email"];
                    $user->phone_number = $phone;
                    $user->hours_notification = $hours_notification;
                    $user->deals_notification = $deals_notification;
                    $user->save();

                    //remove pending user from session
                    Session::forget('pending_user');

                    //log user in
                    Session::put('user', $user);
                    Auth::loginUsingId($user->id);

                    //send user text message about signing up

                    $grille_name = Grille::where('id', $this->grille_id)->pluck('name');
                    $message = "Thanks for signing up for " . $grille_name . "'s online ordering!
                        If you received this message by accident, reply 'STOP'";

                    Sms::send_sms($phone, $message);
                }

                //redirect to most recent page
                $url = Session::get('redirect');
                Session::forget('redirect');
                return Redirect::to($url);
            }
            //else alert user to enter correct phone number
            else
            {
                $failure = 'Please enter a 10-digit phone number';

                //if user already has account
                if (Session::has('user'))
                {
                    $user = Session::get('user');
                    $user->new = 0;
                    $user->grille_number = Grille::where('id', $this->grille_id)->pluck('phone_number');
                    $this->layout->content = View::make('users.edit', ['user' => $user, 'failure' => $failure]);
                }

                //if user is logging in for first time
                else
                {
                    $user = Session::get('pending_user');
                    $this->layout->content = View::make('users.edit', ['user' => $user, 'failure' => $failure]);
                }


            }
        }

        //if not user or pending user, redirect
        else
        {
            try {
            return Redirect::back();
            }
            catch (Exception $e) {
                return Redirect::to('/');
            }
        }

    }

    /**
    * Displays user settings page so user can edit phone number
    * and text blast subscriptions
    * @return Response
    */
    public function user_settings()
    {

        //if existing user, go to settings
        if (Session::has('user'))
        {
            //remember url user is coming from
            Session::put('redirect', URL::previous());

            $user = Session::get('user');
            $failure = Session::get('failure');

            //specify whether user is new or not
            $user->new = 0;
            $user->grille_number = Grille::where('id', $this->grille_id)->pluck('phone_number');

            $this->layout->content = View::make('users.edit', ['user' => $user, 'failure' => $failure]);
        }
        //else redirect back to where came from
        else
        {
            try {
            return Redirect::back();
            }
            catch (Exception $e) {
                return Redirect::to('/');
            }

        }
    }
}








