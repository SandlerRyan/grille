<?php 
	echo Addon::find(1)->addon_items;
?>

<form role="form" method="post" action="/checkout">

@foreach($menu as $category=>$items)
  <h1>{{$category}}</h1>

  @foreach($items as $item)

  	{{{ $item->name }}}
	<input type="text" name="{{$item->id}}" class="form-control" value="" />
  	{{{ $item->description}}}

  	{{{ $item->price}}}

  	<br/>
  @endforeach
@endforeach




        <button type="submit" class="btn btn-default">Submit</button>


</form>
