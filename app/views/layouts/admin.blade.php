@extends('layouts.master')

@section('header')

<!-- for adding the open/closed switch -->
<link rel="stylesheet" href="/css/switchbutton.css"/>
<script src="{{ URL::asset('js/switchbutton.js') }}"></script>

<div id="stickyHeader">
  <div  class="row">
  <div id='cssmenu'>
  <ul>
     <li class='active'><a href='/dashboard'><span>Staff Portal</span></a></li>
     <li><a href='/'><span>Home</span></a></li>
     <li><a href='/inventory'><span>Inventory</span></a></li>
     <li class='has-sub'><a href='#'><span>Orders</span></a>
        <ul>
           <li><a href='/dashboard'><span>Incoming</span></a></li>
           <li><a href='/dashboard/filled_orders'><span>Fulfilled</span></a></li>
           <li class='last'><a href='/dashboard/cancelled_orders'><span>Cancelled</span></a></li>
        </ul>
     </li>
     <li><a href='/dashboard/text_blasts'><span>Text Blasts</span></a></li>
     <li class='last'><a href='/admin' target='_blank'><span>Admin</span></a></li>
  </ul>
  </div>
  </div>
</div>

<script>
$( document ).ready(function() {
$('#cssmenu').prepend('<div id="menu-button">Menu</div>');
  $('#cssmenu #menu-button').on('click', function(){
    var menu = $(this).next('ul');
    if (menu.hasClass('open')) {
      menu.removeClass('open');
    }
    else {
      menu.addClass('open');
    }
  });
});
</script>


<?php
  $grille_id = App::make('grille_id');
  $grille = Grille::find($grille_id);
?>

<div class="row">
  <input id="open-close" type="checkbox" value="1" checked>
</div>


</div>
<!-- <<<<<<< HEAD -->
<!-- Ordinary users and unauthenticated guests already filtered out in routes by this point -->
<!-- @if (Session::get('user')->privileges != 'staff')
  <ul class="button-group radius even-4">
    <li><a class="button" href="/dashboard">Orders</a></li>
    <li><a class="button" href="/inventory">Inventory</a></li>
    <li><a class="button" href="/admin">Admin</a></li>
    <li><a class="button" href="/">Home</a></li>
  </ul>
@else
  <ul class="button-group radius even-3">
    <li><a class="button" href="/dashboard">Orders</a></li>
    <li><a class="button" href="/inventory">Inventory</a></li>
    <li><a class="button" href="/">Main Site</a></li>
  </ul>
@endif
======= -->
<script>
  // set the on/off switch properties
  $("input[type=checkbox]").switchButton({
      width: 50,
      height: 20,
      button_width: 30,
      on_label: 'OPEN',
      off_label: 'GRILLE CLOSED'
  });
</script>

<!-- set default open/closed value upon loading page -->
@if ($grille->open_now)
  <script>$("input[type=checkbox]").switchButton({checked:true});</script>
@else
  <script>$("input[type=checkbox]").switchButton({checked:false});</script>
@endif

<!-- >>>>>>> 85db34346f9a61e56950bb2115519884a9fafa1c -->

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
@stop


<!-- content  -->

