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


	<!-- <div id="totalPrice"><b>Total</b>: ${{Cart::total()}}</div> -->
	<div class="large-3 large-centered columns">
<!-- 	<a class="button success round" href="https://api.venmo.com/v1/oauth/authorize?client_id=1322&scope=make_payments%20access_profile&response_type=token">Pay with Venmo</a>

	<a class="button success round" href="/pay_later">Pay At Grille</a> -->


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
