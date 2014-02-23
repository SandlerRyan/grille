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
        $user = CS50::getUser(RETURN_TO);
        if ($user !== false)
            //$_SESSION["user"] = $user;
            Session::put("user", $user);
       
        // redirect user to index.php
        //$protocol = (Request::secure()) ? "https" : "http";
        //$host  = Request::server("HTTP_HOST");
        //$path = rtrim(dirname(Request::server("PHP_SELF")), "/\\");

        //return Redirect::to('{$protocol}://{$host}{$path}.php');
        return Redirect::to('/checkout');
    }
}