
THIS IS YOUR ORDER DETAILS!

@foreach($form as $item)

	{{{ $item }}}
@endforeach

<button>Pay with Venmo</button>

<button>Pay At Grille</button>

<br/>
<a class="btn btn-lg btn-success" href="/checkout" role="button">Checkout</a>
