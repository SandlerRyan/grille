<<<<<<< HEAD
<div class="row">
    <div class="large-12 columns">
    
      <div class="panel">

	<h3>Order Details</h3>

	<table class="box">
	<tr>
		<th>Item</th>
		<th>Price</th>
		<th>Quantity</th>
	<tr>
	@foreach(Cart::contents() as $item)
	<tr>
		<td>{{$item->name}}</td>
		<td>${{$item->price}}</td>
		<td>{{$item->quantity}}</td>
	</tr>
	@endforeach
	<tr>
		<td></td>
		<td><h5>Total:</h5></td>
		<td><h5 id="totalPrice">${{Cart::total()}}</h5></td>
	</tr>
	</table>
=======
<div class="result">
</div>

THESE ARE YOUR ORDER DETAILS!

@foreach(Cart::contents() as $item)
{{$item->name}}<br/>
{{$item->price}}<br/>
{{$item->quantity}}<br/><br/>
Enter a Note:
<input type="text" class="note" id="text-{{$item->id}}" maxlength="250" />
<button type="button" class="addNote" id="{{$item->id}}">Submit Note</button>
@endforeach
>>>>>>> 9e02d73eacb9a8b17d2dc6234359e84f20a2f654


<<<<<<< HEAD
	<!-- <div id="totalPrice"><b>Total</b>: ${{Cart::total()}}</div> -->
	<div class="large-3 large-centered columns">
<!-- 	<a class="button success round" href="https://api.venmo.com/v1/oauth/authorize?client_id=1322&scope=make_payments%20access_profile&response_type=token">Pay with Venmo</a>
=======
<a href="https://api.venmo.com/v1/oauth/authorize?client_id=1322&
	scope=make_payments%20access_profile&response_type=token">Pay with Venmo</button>
>>>>>>> 9e02d73eacb9a8b17d2dc6234359e84f20a2f654

	<a class="button success round" href="/pay_later">Pay At Grille</a> -->

<<<<<<< HEAD

	<br/>

	    <ul class="button-group round even-2">
          <li><a class="button success" href="https://api.venmo.com/v1/oauth/authorize?client_id=1322&scope=make_payments%20access_profile&response_type=token">Pay with Venmo</a></li>
          <li><a class="button success" href="/pay_later">Pay At Pick-Up</a></li>
        </ul>
	</div>

	<br />

    </div>
  </div>
</div>
=======
<br/>
<a class="btn btn-lg btn-success" href="/order/create" role="button">Back to Menu</a>

<script>
// makes an ajax call to the database to add a note
function add_note ()
{
	$(".addNote").click(function() {
		var id = this.id;
		containerID = "#text-" + id;
		var value = $(containerID).val();
		$.ajax({
			url: "/add_note/" + id + "/" + value,
			type: "get",
			error: function(){
				console.log('error');
				alert("failure");
				$("#result").html('There was an error during submission');
			},
			success: function(data){
				// remove the input box and add note button;
				// replace with the note and an "edit note"
				console.log('success');
				$("#" + id).replaceWith(
					'<button type="button" class="editNote" id="' + id + 
					'">Edit Note</button>');
				$(containerID).replaceWith(
					'<p id="text-' + id + '">' + value + '</p>');
				// attach the edit note handler to the new DOM element
				edit_note();
			}
		});
	});
}

// changes the text back to an input box for editing
function edit_note ()
{
	$(".editNote").click(function() {
		var id = this.id;
		containerID = "#text-" + id;
		var value = $(containerID).text();
		$("#" + id).replaceWith(
			'<button type="button" class="addNote" id="' + id + 
			'">Submit Note</buton>');
		$(containerID).replaceWith(
			'<input type="text" class="note" id="text-' + id + 
			'" value="' + value + '" maxlength="250"/>');
		// attach the add note handler to the new DOM element
		add_note();
	});
}

$(document).ready(function () {
	add_note();
	edit_note();
});

</script>
>>>>>>> 9e02d73eacb9a8b17d2dc6234359e84f20a2f654