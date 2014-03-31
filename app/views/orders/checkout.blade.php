@section('content')

<div class="row">
@if($err_messages)
	<h5><font color="red">{{$err_messages}}</font></h5>
@endif

<div class="large-12 columns">

	<!-- <div class="panel"> -->
		<h3>Order Details</h3>

		<table class="pure-table-horizontal">
			<thead>
				<tr>
					<th>Item</th>
					<th>Price</th>
					<th>Quantity</th>
					<th width="300">Notes</th>
				<tr>
			</thead>
			<tbody>
			@foreach(Cart::contents() as $item)
			<tr>
				<td>{{$item->name}}</td>
				<td>${{$item->price}}</td>
				<td>{{$item->quantity}}</td>
				<td>
				  <form class="pure-form">
					<fieldset>
					  <input type="text" class="note" id="text-{{$item->id}}" maxlength="250" />
					  <button type="button" class="addNote pure-button pure-button-primary" id="{{$item->id}}">Submit Note</button>
					</fieldset>
				  </form>
				</td>
			</tr>
				@if($item->addons)
				<tr>
					@foreach($item->addons as $addon)
						<td> + {{$addon->name}}</td>
						<td> $ {{$addon->price}}</td>
						<td>{{$addon->quantity}}</td>
					@endforeach
				</tr>
				@endif
			@endforeach
			<tr>
				<td></td>
				<td><h5>Total:</h5></td>
				<td><h5 id="totalPrice">${{number_format(Cart::total_with_addons(), 2)}}</h5></td>
			</tr>
			</tbody>
		</table>

		<div class="result"></div>

		@if (Session::has('user'))
		    <a class="button pure-button pure-button-primary" style="margin:5px;" href="{{ Venmo::AUTHENTICATION_URL }}">
		    	Use Venmo
		    </a>
		    <a class="button pure-button pure-button-primary" style="margin:5px;" href="/order/pay_later">Pay At Pick-Up</a>
		@else
		    <a class="button pure-button pure-button-primary" style="margin:5px;" href="/user/login">Log In To Proceed</a>
		@endif
		<br/><br/>
	<!-- </div> -->
</div>
</div>
@stop

@section('additional_static')
<script>
// makes an ajax call to the database to add a note
function add_note ()
{
	$(".addNote").click(function() {
		var id = this.id;
		containerID = "#text-" + id;
		var value = $(containerID).val();
		$.ajax({
			url: "/cart/add_note/" + id + "/" + value,
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
					'<button type="button" class="editNote pure-button pure-button-primary" id="' + id +
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
			'<button type="button" class="addNote pure-button pure-button-primary" id="' + id +
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

@stop