@extends('layouts.master')

@section('header')

<div class="row">
    @if (Grille::find(1)->open_now)
      <button class="open button" style="background-color: green; float: right">Close Grille</button>
    @else
      <button class="open button" style="background-color: green; float: right">Open Grille</button>
    @endif
</div>

<!-- Ordinary users and unauthenticated guests already filtered out in routes by this point -->
@if (Session::get('user')->privileges != 'staff')
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

