@section('content')

<div>
@if($failure)
    <h5><font color="red">{{$failure}}</font></h5>
@endif
</div>

<div class="row">
  <!-- <div class="large-12 columns"> -->
      <div class="panel" id="order.id">

<!-- <form class="pure-form pure-form-aligned">
    <fieldset>
        <div class="pure-control-group">
            <label for="name">Username</label>
            <input id="name" type="text" placeholder="Username">
        </div>

        <div class="pure-control-group">
            <label for="password">Password</label>
            <input id="password" type="password" placeholder="Password">
        </div>

        <div class="pure-control-group">
            <label for="email">Email Address</label>
            <input id="email" type="email" placeholder="Email Address">
        </div>

        <div class="pure-control-group">
            <label for="foo">Supercalifragilistic Label</label>
            <input id="foo" type="text" placeholder="Enter something here...">
        </div>

        <div class="pure-controls">
            <label for="cb" class="pure-checkbox">
                <input id="cb" type="checkbox"> I've read the terms and conditions
            </label>

            <button type="submit" class="pure-button pure-button-primary">Submit</button>
        </div>
    </fieldset>
</form>
 -->

	<form class="pure-form pure-form-aligned" role="form" method="get" action="/user/edit_user">
		<fieldset>

			<div class="pure-control-group">
				<label for="name">Preferred Name</label>
				<input type="text" name="preferred_name" value="{{$user["preferred_name"]}}" />
			</div>

			<div class="pure-control-group">
				<label for="number">Phone Number</label>
				<input type="text" name="phone_number" placeholder = "XXX.XXX.XXXX" />
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

<!-- 		@if($user["new"]==0)
			<div>Note: If you opted to stop receiving text messages and want to opt back in, text 'START' to (843) 271-6240 </>
		@endif -->


		</fieldset>
	</form>


<!-- <table>
	<form role="form" method="get" action="/user/edit_user">
		<div class="row collapse">
			<div class="large-4 columns">
				<label>Preferred Name</label>
				<input type="text" name="preferred_name" value="{{$user["preferred_name"]}}" required/>
			</div>
		</div>
		<div class="row collapse">
			<div class="large-4 columns">
				<label>Phone Number</label>
				<input type="text" name="phone_number" value="{{$user["phone_formatted"]}}" required/>
			</div>
		</div>

		<label for="checkbox1">Update me about special hours</label>
		<input type="checkbox" name="hours_notification" id='checkbox1' />
		<br/>
		<label for="checkbox2">Update me about deals and discounts </label>
		<input type="checkbox" name="deals_notification" id='checkbox2' />

		<div class="row">
			<button type="submit" id="submit" class="radius button">Submit</button>
		</div>
		@if($user["new"]==0)
			<div>Note: If you opted to stop receiving text messages and want to opt back in, text 'START' to {{$user["grille_number"]}} </>
		@endif
	</form>
</table> -->



<!-- </div> -->
</div>

@stop
