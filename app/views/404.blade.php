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

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>



    <!-- Slidebars -->
    <script src="js/slidebars.min.js"></script>

    <!-- Slidebars CSS -->
    <link rel="stylesheet" href="/css/slidebars.min.css">

    <!-- Example Styles -->
    <link rel="stylesheet" href="/css/example-styles.css">

    <link rel="stylesheet" href="/css/slidebars-theme.css">
    <link rel="stylesheet" href="/js/slidebars-theme.js">


    <!-- Toggle Switch -->
    <link rel="stylesheet" href="/css/toggle-switch.css">



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

    <title>Eliot Inferno Grille</title>
  </head>

  <body>

  <!-- <a href="#" class="button [radius round]">Log out</a> -->


      <div class="row">
        <div class="large-12 columns">
          <h1><img width="25" src="/img/logo.jpg" /> Eliot Grille</h1>
        </div>
        <div class="large-6 columns">
            <ul class="inline-list right">
              <?php if(Session::has('user')){ ?>
              <li>Logged in as <?php echo Session::get('user')->preferred_name?></li>
              <li><a href="/user/logout">Log out</a></li>
              <?php }else{ ?>
              <li><a class="button" href="/user/login">Login</a></li>
              <?php } ?>
            </ul>
        </div>
      </div>

      <nav class="row">
        <div class="large-12 columns">
          <!-- <h2>Eliot Grille</h2> -->
          <?php if(Session::has('user') && (Session::get('user')->privileges != 'user')){ ?>
            <ul class="button-group radius even-3">
              <li><a class="button" href="/">Home</a></li>
              <li><a class="button" href="/order/create">Menu</a></li>
              <li><a class="button" href="/admin">Staff</a></li>
<!--             <li><a class="button" href="#">Russian Blue</a></li>
            <li><a class="button" href="#">Scottish Fold</a></li> -->
          </ul>
          <?php }else{ ?>
            <ul class="button-group radius even-2">
              <li><a class="button" href="/">Home</a></li>
              <li><a class="button" href="/order/create">Menu</a></li>
            </ul>
          <?php } ?>
        </div>
      </nav>

    <!-- End Header and Nav -->

    <div class="row">
		<h3>404: Page not found</h3>
	</div>



      <!-- Footer -->
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



    </body>
</html>
