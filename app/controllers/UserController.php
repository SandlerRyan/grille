<?php

class UserController extends \BaseController {
    //Check if user already logged in
    public function login()
    {
        require_once(app_path().'/config/id.php');
        // if user is already logged in, redirect to index.php
        if (Session::has('user'))
        {
            //$protocol = (Request::secure()) ? "https" : "http";
            //$host  = Request::server("HTTP_HOST");
            //$path = rtrim(dirname(Request::server("PHP_SELF")), "/\\");
            //return Redirect::to('{$protocol}://{$host}{$path}.php');
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

        // redirect user to checkout
        //$protocol = (Request::secure()) ? "https" : "http";
        //$host  = Request::server("HTTP_HOST");
        //$path = rtrim(dirname(Request::server("PHP_SELF")), "/\\");
        //return Redirect::to('{$protocol}://{$host}{$path}.php');
        return Redirect::to('/checkout');  
    }

    public function return_to()
    {

        // configuration
        require_once(app_path().'/config/id.php');

        // remember which user, if any, logged in
        $userCS50 = CS50::getUser(RETURN_TO);
        if ($userCS50 !== false)
            
            //Check if User has signed in before. If not, create the user
            $user = User::where('cs50_id', $userCS50['identity'])->get();
            if ($user != "[]") {
                Session::put("user", $user);
            } else {
                //Create User in the database
                $name = explode(" ", $userCS50['fullname']);
                $first_name = $name[0];
                $user = new User();
                $user->cs50_id= $userCS50['identity'];
                $user->name= $userCS50['fullname'];
                $user->email= $userCS50['email'];
                $user->preferred_name = $first_name;
                $user->privileges = "user";
                $user->save();

                Session::put("user", $user);
            }
                
        return Redirect::to('/checkout');
    }
}