<?php

    // URL that CS50 ID should ask users to trust; must be a prefix of RETURN_TO and
    // must be registered with CS50, per https://manual.cs50.net/ID
    define("TRUST_ROOT", "http://localhost:8000/");

    // URL to which CS50 ID should return users;
    // must be registered with CS50, per https://manual.cs50.net/id/
    define("RETURN_TO", "http://localhost:8000/return_to");

    // CS50 Library; ideally, this should not be inside public_html (or DocumentRoot)
    require_once(app_path().'/config/CS50/CS50.php');

    // ensure $_SESSION exists
    session_start();

?>
