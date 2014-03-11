@section('content')

<div>
@if($failure)
    <h5><font color="red">{{$failure}}</font></h5>
@endif
</div>

<div class="row">
  <div class="large-12 columns">
      <div class="panel" id="order.id">


<table>
	<form role="form" method="get" action="/user/edit_user">
		<div class="row collapse">
			<div class="large-4 columns">
				<label>Preferred Name</label>
				<input type="text" name="preferred_name" value="{{$pending_user["preferred_name"]}}" />
			</div>
		</div>
		<div class="row collapse">
			<div class="large-4 columns">
				<label>Phone Number</label>
				<input type="text" name="phone_number" placeholder = "XXX.XXX.XXXX" />
			</div>
		</div>

		<label for="checkbox1">Update me about special hours</label>
		<input type="checkbox" name="hours_notification" id='checkbox1' />

		<br/>

		<label for="checkbox2">Update me about deals and discounts </label>
		<input type="checkbox" name="deals_notification" id='checkbox2' />
	</form>

	<div class="row">
		<button type="submit" id='submit' class='radius button'>Submit</button>
	</div>
</table>

</div>
</div>

@stop
