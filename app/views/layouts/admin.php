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


          <?php if(Session::get('user')->privileges == ('manager'||'admin')){ ?>
            <ul class="button-group radius even-3">
              <li><a class="button" href="/dashboard">Orders</a></li>
              <li><a class="button" href="/inventory">Inventory</a></li>
              <li><a class="button" href="/admin">Admin Portal</a></li>
            </ul>
          <?php } else { ?>
            <ul class="button-group radius even-2">
              <li><a class="button" href="/dashboard">Orders</a></li>
              <li><a class="button" href="/inventory">Inventory</a></li>
            </ul>
          <?php } ?>

    <!-- End Header and Nav -->
          <div class="button alert sb-toggle-left">
        In-Stock Side Bar
      </div>

    <!-- </div> -->
    <!-- Left Slidebar -->
    <div class="sb-slidebar sb-left">

      <!-- Lists in Slidebars -->
      <ul class="sb-menu">


        @foreach($items as $item)
          <li>

            @if ($item->available)


            <button style="width: 100%;" class="button success mark_item_unavailable" id="{{$item->id}}">
              {{ $item->name}}

            </button>
            
            @else
              <button style="width: 100%;" class="button alert mark_item_available" id="{{$item->id}}">
              {{ $item->name }}

              </button>

            @endif

          </li>

        @endforeach

      </ul>


    </div>


    <!-- content  -->
    <?= $content; ?>



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


    <script>
      (function($) {
        $(document).ready(function() {
          var mySlidebars = new $.slidebars();

          $('.toggle-left').on('click', function() {
            mySlidebars.toggle('left');
          });

          $('.toggle-right').on('click', function() {
            mySlidebars.toggle('right');
          });

          $('.open-left').on('click', function() {
            mySlidebars.open('left');
          });

          $('.open-right').on('click', function() {
            mySlidebars.open('right');
          });

          $('.close').on('click', function() {
            mySlidebars.close();
          });
        });
      }) (jQuery);
    </script>


    </body>


</html>
