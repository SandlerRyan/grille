<!-- First Band (Slider) -->
@if($err_messages)
    <h5><font color="red">{{$err_messages}}</font></h5>
@endif
<div class="row">
<!-- <div class="large-12 columns"> -->
	@if($open==1)
		<!-- <h1 id="neon-tubing">Open</h1> -->
		<h3 style="width: 100%; text-align:center;">
			We're open! Check out our <a class="" href="/order/create">menu</a>.
		</h3>
	@else
		<h1 id="neon-tubing">Sorry, we're closed :(</h1>
	@endif
</div>


<!-- <div class="row"> -->
<table class="box">
<caption><h4>Hours</h4></caption>
	<thead>
    	<tr>
    		<th width="200">Day</th>
    		<th width="200">Opens</th>
    		<th width="200">Closes</th>
		</tr>
	</thead>
	<tbody>
      	@foreach($hours as $hour)
      	<tr>
      		<td>{{$hour->day_of_week}}</td>
      		<td>{{$hour->open_time}}</td>
      		<td>{{$hour->close_time}}</td>
      	</tr>
      	@endforeach
  	</tbody>
</table>


<div class="row">
<h4 style="width: 100%; text-align:center;">Where to Find Us</h4>
<h5 style="width: 100%; text-align:center;">J-Entryway Basement</h5>
  <img class="displayed" src="/img/map.png" />
</div>