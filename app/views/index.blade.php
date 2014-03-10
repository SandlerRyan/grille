<?php
// get the hours of the grille
$grille_id = 1;
$hours = Hour::where('grille_id', $grille_id)->get();
$hourlist = array();

// reformat all hours as an array with each day of the week as a key
// and all open and close times as values
foreach($hours as $hour)
{
	if(array_key_exists($hour->day_of_week, $hourlist)) {
		array_push($hourlist[$hour->day_of_week], array(
											'open' => $hour->open_time,
											'close' => $hour->close_time));
	}
	else {
		$hourlist[$hour->day_of_week] = array(0 => array(
											'open' => $hour->open_time,
											'close' => $hour->close_time));
	}
}

?>
	<!-- First Band (Slider) -->

	  <div class="row">
	    <div class="large-12 columns">
	    	@if($open==1)
	    	<h1>Open</h1>
	    	@else
	    	<h1>Closed</h1>
	    	@endif
	    	<table class='box'>
	    	<tr>
	    		<th>Day</th>
	    		<th>Opens</th>
	    		<th>Closes</th>
    		</tr>
	      	@foreach($hours as $hour)
	      	<tr>
	      		<td>{{$hour->day_of_week}}</td>
	      		<td>{{$hour->open_time}}</td>
	      		<td>{{$hour->close_time}}</td>
	      	</tr>
	      	@endforeach
    	  @if($err_messages)
		    <h5><font color="red">{{$err_messages}}</font></h5>
		  @endif
	    <div id="slider">
	    </div>


	    <hr />

	    </div>
	  </div>

	<!-- Three-up Content Blocks -->

<!-- <div class="row">

	    <div class="large-4 columns">
	      <h4>Hours</h4>
	      <ul>
	      	<li><b>Monday</b></li>
	      	<li><b>Tuesday</b></li>
	      	<li><b>Wednesday</b></li>
	      	<li><b>Thursday</b></li>
	      	<li><b>Friday</b></li>
	      	<li><b>Saturday</b></li>
	      	<li><b>Sunday</b></li>
	      </ul>
	    </div> -->

<!-- 	    <div class="large-3 columns">
	      <img src="/img/map.png" />
	      <h4>Where to find us?</h4>
	      <p>
	      	The Eliot Grille, also known as "Inferno", is located in the basement of Eliot House, 101 Dunster Street.
	      </p>
	    </div> -->


	    <!-- <div class="large-1 columns"> -->
	      <!-- <img src="http://placehold.it/400x300&text=[img]" />
	      <h4>This is a content section.</h4>
	      <p>Bacon ipsum dolor sit amet nulla ham qui sint exercitation eiusmod commodo, chuck duis velit. Aute in reprehenderit, dolore aliqua non est magna in labore pig pork biltong. Eiusmod swine spare ribs reprehenderit culpa. Boudin aliqua adipisicing rump corned beef.</p>
	    </div> -->
	    <!-- </div> -->


	<!-- Call to Action Panel -->
	<div class="row">
		<div class="large-4 columns"></div>
	    <div class="large-4 columns">

	      <!-- <div class="panel"> -->
	        <!-- <h4>See the menu</h4> -->
	        <!-- <div class="row"> -->
<!-- 	          <div class="large-9 columns">
	            <p>Check out our selection of delicious items.</p>
	          </div> -->
	          <!-- <div class="row"> -->
	            <a href="/order/create" class="button alert round"><h4 style="color: white;">I'm hungry!</h4></a>
	          <!-- </div> -->
	        <!-- </div> -->
	      <!-- </div> -->

	    </div>
	    <div class="large-4 columns"></div>
	  </div>

