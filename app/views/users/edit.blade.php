@section('content')

<div class="row">
	@if($failure)
	    <h5><font color="red">{{$failure}}</font></h5>
	@endif
</div>

<div class="row">
  <div class="panel" id="order.id">

	<form class="pure-form pure-form-aligned" role="form" method="get" action="/user/edit_user">
		<fieldset>

			<div class="pure-control-group">
				<label for="name">Preferred Name</label>
				<input type="text" name="preferred_name" value="{{$user["preferred_name"]}}" required />
			</div>

			<div class="pure-control-group">
				<label for="number">Phone Number</label>
				<input type="text" name="phone_number" value="{{$user["phone_formatted"]}}" required />
			</div>


			<div class="pure-controls">
	            <label for="cb" class="pure-checkbox">
	                <input type="checkbox" name="hours_notification" id='checkbox1'/>
	                Update me about special hours
	            </label>

	           	<label for="cb" class="pure-checkbox">
	                <input type="checkbox" name="deals_notification" id='checkbox2' />
	                Update me about deals and discounts
	            </label>

	            <button type="submit" id="submit" class="radius button">Submit</button>
	        </div>

		</fieldset>
	</form>

	@if($user["new"]==0)
		<h6>Note: If you opted to stop receiving text messages and want to opt back in, text 'START' to (843) 271-6240 <h6/>
		<br/>
	@endif


  </div>
</div>

@stop
