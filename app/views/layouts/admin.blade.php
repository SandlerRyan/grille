@extends('layouts.master')

@section('header')

<!-- for adding the open/closed switch -->
<link rel="stylesheet" href="/css/switchbutton.css"/>
<script src="{{ URL::asset('js/switchbutton.js') }}"></script>

<div id="stickyHeader">
  <div  class="row">
    <!-- <div class="large-12 columns"> -->
    <h4>
      <a id="logo" href="/">Staff Portal</a></li>
    </h4>


    <a class="nav-item" href="/">Home</a>
    <a class="nav-item" href="/inventory">Inventory</a>
    <a class="nav-item" href="/admin">Admin</a>

    <ul>
      <li class="drop">
        <a>Orders</a>
          <div class="dropdownContain">
            <div class="dropOut">
              <div class="triangle"></div>
              <ul>
                <li>
                  <a class="dropdown-item" href="/dashboard">Incoming</a>
                </li>
                <li>
                  <a class="dropdown-item" href ="/dashboard/filled_orders">Fulfilled</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/dashboard/cancelled_orders">Cancelled</a>
                </li>
                <li>
                  <a class="dropdown-item" href="/dashboard/text_blasts">Text Blasts</a>
                </li>
              </ul>
            </div>
          </div>
      </li>
    <ul>

  </div>
</div>

<?php
  $grille_id = App::make('grille_id');
  $grille = Grille::find($grille_id);
?>

<div class="row">
  <input id="open-close" type="checkbox" value="1" checked>
</div>

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

