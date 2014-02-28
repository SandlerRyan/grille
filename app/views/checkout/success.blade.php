<div class="row">
    <div class="large-12 columns">	

    <div class="panel">

	<h3>{{{$response }}}</h3>

	<h5><b>Order number:</b>{{ $order->id }}</h5>
	<h5>Order Items:</h5>

	@foreach($order->item_orders as $item)
		{{ $item->name }}
		{{ $item->quantity }}
		{{ $item->price }}
	@endforeach
	
	<h5><b>ETA:</b> 10 minutes.</h5> 


	<form>
	  <fieldset>
	    <legend>Leave your phone number here to get notifications</legend>

	    <label>Phone number
	      <input type="text" class="phoneInput" id="{{$order->user_id}}" 
	      	value="{{User::findorfail($order->user_id)->phone_number}}"/>
	      <button type="button" class="addPhone">Submit</button>
	    </label>
	  </fieldset>
	</form>

	{{{ $response }}}

	<br />

    </div>
  </div>
</div>

<script>
// if phone number doesn't exist yet, add a placeholder
$(document).ready(function (){
	var phone = $(".phoneInput").val();
	var order_id = $(".phoneInput").attr('id');
	if(phone == ""){
		$(".phoneInput").replaceWith(
			'<input type="text" class="phoneInput" id="' + order_id + 
			'" placeholder="Format: 5551234567"/>');
	}
});

// ajax call to the back end to add user's phone number
$(".addPhone").click(function (){
	// TODO: Check phone number formatting with a regex
	var phone = $(".phoneInput").val();
	$.ajax({
		url: "/add_phone/" + phone,
		type: "get",
		success: function(data){
			$(".addPhone").remove();
			$(".phoneInput").replaceWith(
				'<div>Thanks! Updates on this order will be sent to' + phone + '</div>');
		},
		error: function(){
			alert("Could not add phone number");
		}
	});
});
</script>







