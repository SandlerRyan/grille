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
	      <input type="text" placeholder="(XXX) XXX-XXXX">
	    </label>
	  </fieldset>
	</form>

	{{{ $response }}}

	<br />

    </div>
  </div>
</div>