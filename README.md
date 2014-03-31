----------------------------------------------------
THE HARVARD GRILLES APP
----------------------------------------------------
An app for placing orders remotely at the Harvard grilles,
created by Team SeniorSpring for Harvard CS164 and written in Laravel
- Vladimir Bok
- Ian Boothby
- Ryan Sandler
- Nuseir Yassin


----------------------------------------------------
I. External Code
----------------------------------------------------
Other than Laravel, this project has made use of many open-source packages, listed below.
Some of these packages are listed in /composer.json, so simply running 'composer update'
should ensure that they are included. The rest are either included in version control or loaded
from the internet directly at runtime.

1. Jquery - javascript library for manipulating the DOM

2. Foundation - css library for many types of styling

3. Twilio - for interacting with the twilio API; most package files located in config/twilio-php

4. Frozennode administrator - an AngularJS-based laravel package that creates an admin panel,
		allowing user modification of the database directly from the website

5. Moltin Cart - a laravel package implementing a cart object in session
		* NOTE: We have made several direct modifications to the source code of this package.
		Therefore, the moltin/cart files are not regulated by composer and are instead
		included in version control; they are autoloaded in the app via psr-0.

6. Ardent - package for improved testing

7. CS50ID - allows authentication to be handled through the HUID system; most files located in config/CS50.


----------------------------------------------------
II. Installation
----------------------------------------------------
After cloning the source files for this website from git, simply run "composer update" in the root
directory of the app.


----------------------------------------------------
III. Additional Code
----------------------------------------------------
We have code located in various files outside of the usual Laravel folders.

1. Most of the cart logic is located in the file moltin/cart/src/Moltin/Cart/Cart.php. This file was originally
part of the moltin/cart package, but we had issues extending the Cart class in a separate file and instead
modified the Cart class directly to add logic for addon handling.

2. Several additional classes that we have written are located in the classes/ folder. These handle operations
used throughout the website, including Venmo payments and Twilio texting; they are loaded into the global namespace.

3. The config/administrator/ folder contains the config files used to configure the frozennode administrator package.
These files tell the admin panel which eloquent models to load, how to display the information, and how fields can be
filtered and edited. The master config file for this package is located at config/packages/frozennode/administrator/administrator.php.


----------------------------------------------------
IV. Included from the Laravel README
----------------------------------------------------
## Laravel PHP Framework

[![Latest Stable Version](https://poser.pugx.org/laravel/framework/version.png)](https://packagist.org/packages/laravel/framework) [![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.png)](https://packagist.org/packages/laravel/framework) [![Build Status](https://travis-ci.org/laravel/framework.png)](https://travis-ci.org/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, and caching.

Laravel aims to make the development process a pleasing one for the developer without sacrificing application functionality. Happy developers make the best code. To this end, we've attempted to combine the very best of what we have seen in other web frameworks, including frameworks implemented in other languages, such as Ruby on Rails, ASP.NET MVC, and Sinatra.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the entire framework can be found on the [Laravel website](http://laravel.com/docs).

### Contributing To Laravel

**All issues and pull requests should be filed on the [laravel/framework](http://github.com/laravel/framework) repository.**

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
