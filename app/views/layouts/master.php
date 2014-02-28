<!doctype html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
  <head>
    <meta charset="utf-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width" />

    <!-- For third-generation iPad with high-resolution Retina display: -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://foundation.zurb.com/img/favicons/apple-touch-icon-144x144-precomposed.png">
    <!-- For iPhone with high-resolution Retina display: -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://foundation.zurb.com/img/favicons/apple-touch-icon-114x114-precomposed.png">
    <!-- For first- and second-generation iPad: -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://foundation.zurb.com/img/favicons/apple-touch-icon-72x72-precomposed.png">
    <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
    <link rel="apple-touch-icon-precomposed" href="http://foundation.zurb.com/img/favicons/apple-touch-icon-precomposed.png">
    <link rel="icon" href="http://foundation.zurb.com/img/favicons/favicon.ico" type="image/x-icon">
    <title>Foundation Docs: Kitchen Sink</title>
    <link rel="stylesheet" href="http://foundation.zurb.com/docs/assets/normalize.css" />
    <link rel="stylesheet" href="/css/app.css" />
    <script src="/packages/aheissenberger/foundation/js/vendor/custom.modernizr.js"></script>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>    
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


    <script type="text/javascript" src="/js/jquery.sticky.js"></script>

  </head>

  <body>

  <!-- <a href="#" class="button [radius round]">Log out</a> -->


      <div class="row">

        <div class="large-12 columns">

          <h1><img width="25" src="/img/logo.jpg" /> Eliot Grille</h1>
        </div>
       </div>

      <nav class="row">
        <div class="large-12 columns">
          <!-- <h2>Eliot Grille</h2> -->
          <ul class="button-group radius even-2">
            <li><a class="button" href="/">Home</a></li>
            <li><a class="button" href="/order/create">Menu</a></li>
<!--             <li><a class="button" href="#">Russian Blue</a></li>
            <li><a class="button" href="#">Scottish Fold</a></li> -->
          </ul>
        </div>
      </nav>
    </div>
      
    <!-- End Header and Nav -->

           <?= $content; ?> 

      <!-- Footer -->
      <footer class="row">
        <div class="large-12 columns">
          <hr />
          <div class="row">
            <div class="large-6 columns">
              <p>© 2014 Eliot Grille</p>
            </div>
            <div class="large-6 columns">
              <ul class="inline-list right">
                <li><a href="/">Home</a></li>
                <li><a href="/order/create">Menu</a></li>
                <li><a href="/logout">Log out</a></li>
              </ul>
            </div>
          </div>
        </div> 
      </footer>

    </body>

</html>
