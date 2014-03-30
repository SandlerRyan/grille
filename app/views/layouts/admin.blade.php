@extends('layouts.master')

@section('header')
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


<div class="row">
    @if (Grille::find(1)->open_now)
      <button class="open button" style="background-color: green; float: right">Close Grille</button>
    @else
      <button class="open button" style="background-color: green; float: right">Open Grille</button>
    @endif
</div>


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

