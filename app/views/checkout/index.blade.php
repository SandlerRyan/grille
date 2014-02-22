<?php
var_dump(Cart::contents());
?>

THESE ARE YOUR ORDER DETAILS!

@foreach(Cart::contents() as $item)
{{$item->name}}<br/>
{{$item->price}}<br/>
{{$item->quantity}}<br/><br/>
Enter a Note:
<input type="text" class="note" id="text-{{$item->id}}" maxlength="250" />
<button type="button" class="addNote" id="{{$item->id}}">Submit Note</button>
@endforeach

<div id="totalPrice"><b>Total</b>: {{Cart::total()}}</div>

<a href="https://api.venmo.com/v1/oauth/authorize?client_id=1322&
	scope=make_payments%20access_profile&response_type=token">Pay with Venmo</button>

<a href="/pay_later">Pay At Grille</a>

<br/>
<a class="btn btn-lg btn-success" href="/order/create" role="button">Back to Menu</a>

<script>
$(".addNote").click(function() {
	console.log("hi");
	var id = this.id;
	containerID = "#text-" + id;
	var value = $(containerID).val();
	console.log(id);
	console.log(value);
	$.ajax({
		url: "/add_note/" + id + "/" + value,
		type: "get",
		error: function(){
			alert("failure");
			$("#result").html('There was an error during submission');
		},
		success: function(data){
			// remove the input box and add note button;
			// replace with the note and an "edit note"
			$("#" + id).replaceWith(
				'<button type="button" class="addNote" id="' + id + 
				'">Edit Note</button>');
			$(containerID).replaceWith(
				'<p>' + value + '</p>');
		}
	});
});


</script>