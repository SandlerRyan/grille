<table>
	<form onsubmit="return validate(this);" role="form" method="get" action="/dashboard/send_text_blast">
		<div class="row collapse">
			<div class="large-4 columns">
				<label>Type</label>
				<input id = "deal" type="radio" name="alert_type" value="deal" required>Deal Notification<br>
				<input id = "hour" type="radio" name="alert_type" value="hour">Hour Notification
			</div>
		</div>
		<div class="row collapse">

			<label>Message Text:</label>
			<input type="textarea" name="message" required/>
		</div>
		<div class="row">
			<button type="submit" id="submit" class="radius button">Send</button>
		</div>
	</form>
</table>

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
