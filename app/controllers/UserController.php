<?php

class UserController extends \BaseController {
    //Check if user already logged in
    public function login()
    {
        require_once(app_path().'/config/id.php');
        // if user is already logged in, redirect to index.php
        if (Session::has('user'))
        {
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

        // redirect user back to checkout
        return Redirect::to('/checkout');  
    }

    public function return_to()
    {

        // configuration
        require_once(app_path().'/config/id.php');

        // remember which user, if any, logged in
        $user = CS50::getUser(RETURN_TO);

        if ($user !== false)
            Session::put("user", $user);
            

        //check if returning user, return to checkout page
        $rules = array('id' => 'unique:users,email');

$validator = Validator::make($input, $rules);
        return Redirect::to('/checkout');
    }


    public function create()
    {

    }
}