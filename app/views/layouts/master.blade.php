<!doctype html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
  <head>
    <meta charset="utf-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- For third-generation iPad with high-resolution Retina display: -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://foundation.zurb.com/img/favicons/apple-touch-icon-144x144-precomposed.png">
    <!-- For iPhone with high-resolution Retina display: -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://foundation.zurb.com/img/favicons/apple-touch-icon-114x114-precomposed.png">
    <!-- For first- and second-generation iPad: -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://foundation.zurb.com/img/favicons/apple-touch-icon-72x72-precomposed.png">
    <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
    <link rel="apple-touch-icon-precomposed" href="http://foundation.zurb.com/img/favicons/apple-touch-icon-precomposed.png">
    <link rel="icon" href="http://foundation.zurb.com/img/favicons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="http://foundation.zurb.com/docs/assets/normalize.css" />
    <link rel="stylesheet" href="/css/app.css" />
    <link rel="stylesheet" href="/css/style.css" />

    <!-- Pure -->
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.2/pure-min.css">
<!-- </div> -->
<!-- </div> -->
 <!-- <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet"> -->
<!-- </div> -->
<!-- </div> -->


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

    <!-- Slidebars -->
    <script src="{{ URL::asset('js/slidebars.min.js') }}"></script>

    <!-- Slidebars CSS -->
    <link rel="stylesheet" href="/css/slidebars.min.css">

    <!-- Example Styles -->
    <link rel="stylesheet" href="/css/example-styles.css">

    <link rel="stylesheet" href="/css/slidebars-theme.css">
    <link rel="stylesheet" href="/js/slidebars-theme.js">

    <!-- Toggle Switch -->
    <!-- <link rel="stylesheet" href="/css/toggle-switch.css"> -->

    <!-- Responsive Tables -->
    <!-- Included CSS Files -->
    <!-- Combine and Compress These CSS Files -->
    <link rel="stylesheet" href="/css/tables/globals.css">
    <link rel="stylesheet" href="/css/tables/typography.css">
    <link rel="stylesheet" href="/css/tables/grid.css">
    <link rel="stylesheet" href="/css/tables/ui.css">
    <link rel="stylesheet" href="/css/tables/forms.css">
    <link rel="stylesheet" href="/css/tables/orbit.css">
    <link rel="stylesheet" href="/css/tables/reveal.css">
    <link rel="stylesheet" href="/css/tables/mobile.css">

    <title>Harvard Grilles</title>
  </head>

  <body>

  @section('header')

  <!-- Get the requested grille object through the IOC -->
  <?php $grille_id = App::make('grille_id');
    $grille = Grille::find($grille_id);
  ?>

  <div id="stickyHeader">
    <div  class="row">
      <!-- <div class="large-12 columns"> -->
      <h4>
        <a id="logo" href="/">{{$grille->name}}</a></li>
      </h4>

        @if (Session::has('user') && (Session::get('user')->privileges != 'user'))
            <a class="nav-item" href="/order/create">Menu</a>
            <a class="nav-item" href="/dashboard">Staff</a>
        @else
            <a class="nav-item" href="/order/create">Menu</a>
        @endif

        @if (Session::has('user'))
        <ul>
          <li class="drop">
              Hello, <a><b>{{Session::get('user')->preferred_name}}</b></a>
              <div class="dropdownContain">
                <div class="dropOut">
                  <div class="triangle"></div>
                  <ul>
                    <li>
                    <a class="dropdown-item" href="/user/user_settings">
                    Settings</a></li>
                    <li><a class="dropdown-ite" href ="/user/logout">Logout</a></li>
                  </ul>
                </div>
              </div>
          </li>
        <ul>

        @else
          <a id="login" href="/user/login">Login</a>
        @endif

    </div>
  </div>

  <div class="row">
    <div class="large-12 columns">
      <h1><img width="25" src="/img/logo.jpg" /> Eliot Grille</h1>
    </div>
  </div>
  @show


  <!-- End Header and Nav -->

  @yield('content')

  <!-- Footer -->
  @section('footer')
  <footer class="row">
    <div class="large-12 columns">
      <hr />
      <div class="row">
        <div class="large-6 columns">
          <p>© 2014 Eliot Grille</p>
        </div>
      </div>
    </div>
  </footer>
  @show

  @yield('additional_static')

  </body>

</html>
