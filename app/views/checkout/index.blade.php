
THIS IS YOUR ORDER DETAILS!

@foreach(Cart::contents() as $item)
{{$item->name}}<br/>
{{$item->price}}<br/>
{{$item->quantity}}<br/><br/>
@endforeach

<div id="totalPrice"><b>Total</b>: {{Cart::total()}}</div>


<br/>
<a class="btn btn-lg btn-success" href="/checkout" role="button">Checkout</a>

@if ($loggedin)
	<h1>You are logged in!</h1>
	<div>
		<a href="https://api.venmo.com/v1/oauth/authorize?client_id=1322&scope=make_payments%20access_profile&response_type=token">Pay with Venmo</button>
	</div>
	<div>
		<a href="/pay_later">Pay At Grille</a>
	</div>
	<div>
		<a href='/logout'>Log out</a>.
	</div>
@else
	<a href='/login'>Log in</a>.
@endif

