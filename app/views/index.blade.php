@section('content')

<?php
Venmo::refund_order(8);
?>
<!-- First Band (Slider) -->
<div class="row">
  @if($err_messages)
    <h5><font color="red">{{$err_messages}}</font></h5>
  @endif
<!-- <div class="large-12 columns"> -->
	@if($open==1)
		<!-- <h1 id="neon-tubing">Open</h1> -->
		<h3 style="width: 100%; text-align:center;">
			We're open! Check out our <a class="" href="/order/create">menu</a>.
		</h3>
	@else
		<h3 style="width: 100%; text-align:center;">
			Sorry, we're closed :(
		</h3>
	@endif
</div>

<h4 style="width: 100%; text-align:center;">Hours</h4>
<table class="box" style="margin:auto;">
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

<br/>

<div class="row">
  <h4 style="width: 100%; text-align:center;">Where to Find Us</h4>
  <h5 style="width: 100%; text-align:center;">J-Entryway Basement</h5>
  <img class="displayed" src="/img/map.png" />
</div>
<br />

@stop