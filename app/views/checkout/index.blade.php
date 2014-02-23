<div class="row">
    <div class="large-12 columns">
    
      <div class="panel">

	<h3>Order Details</h3>

	@foreach(Cart::contents() as $item)
		{{$item->name}}<br/>
		{{$item->price}}<br/>
		{{$item->quantity}}<br/><br/>
	@endforeach

	<h4>Total: ${{Cart::total()}}</h4>
	<!-- <div id="totalPrice"><b>Total</b>: ${{Cart::total()}}</div> -->

	<a class="button success round" href="https://api.venmo.com/v1/oauth/authorize?client_id=1322&scope=make_payments%20access_profile&response_type=token">Pay with Venmo</a>

	<a class="button success round" href="/pay_later">Pay At Grille</a>

	<br/>
	<a class="button alert round" href="/checkout" role="button">Checkout</a>

	<br/>

    </div>
  </div>
</div>
