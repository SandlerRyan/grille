<?php 
Cart::destroy();
function increment($id)
{
    $item = Item::select('id','name','price','available')->where('id',$id)->get()[0];
    // add necessary fields
    $item['quantity'] = 1;
    $item['notes'] = "";
    //turn json into a php array
    $item = json_decode($item,true);
    // insert will add a new item if not already in cart, 
    // or increment item if it exists already
    Cart::insert($item);
}

function decrement($id)
{
  $item = Cart::find($id);
  // check if item exists; if quantity is already zero, do nothing
  if ($item)
      //if quantity is 1, remove item
      if ($item->quantity == 1)
      {
          Cart::remove($item->identifier);
      }
      else
      {
          $item->quantity -- ;
      }
}

increment(1);
increment(1);
//decrement(1);

var_dump(Cart::find(1));

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
