
THIS IS YOUR ORDER DETAILS!

@foreach($form as $item)

	{{{ $item }}}
@endforeach

<a href="https://api.venmo.com/v1/oauth/authorize?client_id=1322&scope=make_payments%20access_profile&response_type=token">Pay with Venmo</button>

<a href="/pay_later">Pay At Grille</a>

<br/>
<a class="btn btn-lg btn-success" href="/checkout" role="button">Checkout</a>
