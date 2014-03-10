
<!-- First Band (Slider) -->

<div class="row">
<!-- <div class="large-12 columns"> -->
	@if($open==1)
		<h1 id="neon-tubing">Open</h1>
	@else
		<h1 id="neon-tubing">Closed</h1>
	@endif
</div>


<!-- <div class="row"> -->
<table class="box">
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

  @if($err_messages)
    <h5><font color="red">{{$err_messages}}</font></h5>
  @endif

<div class="row">
  <img class="displayed" src="/img/map.png" />
</div>