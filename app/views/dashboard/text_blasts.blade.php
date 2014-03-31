@extends('layouts.admin')

@section('content')


<!-- <table> -->
<div class="row">
<div class="panel">
	<form <form class="pure-form"
	onsubmit="return validate(this);" role="form" method="get" action="/dashboard/send_text_blast">
			<!-- <div class="large-4 columns"> -->
				<h4>Type</h4>
				<label class="pure-radio">
				  <input id="deal" type="radio" name="alert_type" value="deal" checked> Deal Notification
				</label>
				<label class="pure-radio">
				  <input id="hour" type="radio" name="alert_type" value="hour"> Hour Notification
				</label>
			<!-- </div> -->
		<!-- </div> -->
		<!-- <div class="row collapse"> -->

			<h4>Message Text:</h4>
			<textarea name="message"></textarea>
			<br/>
		<!-- </div> -->
		<!-- <div class="row"> -->
			<button type="submit" id="submit" class="pure-button pure-button-primary">Send</button>
		<!-- </div> -->
	</form>

	</div>
	</div>

<!-- </table> -->

<script>
function validate(form) {

 	var message = form.message.value;
 	//get selected type
 	var type;
 	if(document.getElementById("deal").checked) {
 		type = document.getElementById("deal").value;
 	}
 	else if (document.getElementById("hour").checked) {
 		type = document.getElementById("hour").value;
 	}
 	
    return confirm('The following message will be sent to all customers who signed up for ' +
    	type + ' notifications:\n\n' + message);
}
</script>



@stop
