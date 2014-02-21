<?php 
// Cart::destroy();
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

// increment(1);
// increment(1);
// //decrement(1);



?>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>



<div id="result"></div>


<form role="form" method="post" action="/checkout">

@foreach($menu as $category=>$items)
  <h1>{{$category}}</h1>

  @foreach($items as $item)

  	{{{ $item->name }}}

    <button type="button" class="addItem" id="{{{$item->id}}}">Add Item</button>
    <?php $qty = Cart::find($item->id);
      if ($qty) {
        $qty = $qty->quantity;
      } else {
        $qty = 0;
      }
      ?> 
    <input type="text" id="value-{{$item->id}}" value="{{{ $qty }}}" />
    <button type="button" class="removeItem" id="{{{$item->id}}}">Remove Item</button>
	  

  	{{{ $item->description}}}

  	{{{ $item->price}}}

  	<br/>
  @endforeach
@endforeach




        <button type="submit" class="btn btn-default">Submit</button>


</form>



<script>
console.log($("#addItem"));

$(".addItem").click(function(){
  console.log("clicked");
  var id = this.id;
  url = "/increment/" + id;
  $.ajax({
          url: url,
          type: "get",
          success: function(){
              containerId = "#value-" + id;
              value = $(containerId).val();
              $(containerId).val(parseInt(value) + 1);
          },
          error:function(){
              alert("failure");
              $("#result").html('There is error while submit');
          }
      });
})

$(".removeItem").click(function(){
  console.log("clicked");
  var id = this.id;
  url = "/decrement/" + id;
  $.ajax({
          url: url,
          type: "get",
          success: function(){
              containerId = "#value-" + id;
              value = $(containerId).val();
              if (value > 0) {
                $(containerId).val(parseInt(value) - 1);  
              } else {
                $(containerId).val(0);  
              }
            
          },
          error:function(){
              alert("failure");
              $("#result").html('There is error while submit');
          }
      });
})

</script>