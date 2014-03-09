<div class="row">
This is a list of all filled orders
<br/>

<div id="show_orders">


</div>

@foreach($orders as $order)
	
    <div style='width: 300px; height: 300px; background-color: gray;float: left; margin-right: 5%; margin-bottom: 5%;' class='order'>

    {{ $order->user->name }}
    {{ $order->item_orders}}
    </div>
@endforeach
</div>
