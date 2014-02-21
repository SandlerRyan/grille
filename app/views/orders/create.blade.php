

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
    <input type="text" class="itemQuantity" id="value-{{$item->id}}" value="{{{ $qty }}}" />
    <button type="button" class="removeItem" id="{{{$item->id}}}">Remove Item</button>
	  

  	{{{ $item->description}}}

  	{{{ $item->price}}}

  	<br/>
  @endforeach
@endforeach




        <button type="submit" class="btn btn-default">Checkout</button>
        <br/>
        
</form>

<button type="button" class="clearCart">Clear Cart</button> 

<div id="totalPrice">${{{Cart::total()}}}</div>



<script>

$(".clearCart").click(function() {
  var url = "/empty_cart";
  $.ajax({
          url: url,
          type: "get",
          success: function(data){
              //update cart
              var data = JSON.parse(data);
              var total = data.cart;
              var total =  "$" + total;
              $("#totalPrice").html(total);
              
              //clear all inputs without having to refresh the page
              $(".itemQuantity").each(function(i, obj){
                $(obj).val(0);
              })

          },
          error:function(){
              alert("Sorry, something bad happened.");
          }
      });
})

//Ajax call to add item
$(".addItem").click(function(){
  console.log("clicked");
  var id = this.id;
  url = "/increment/" + id;
  $.ajax({
          url: url,
          type: "get",
          success: function(data){
              console.log(data)

              //update counter
              containerId = "#value-" + id;
              value = $(containerId).val();
              $(containerId).val(parseInt(value) + 1);

              //update cart
              var data = JSON.parse(data);
              var total = data.cart;
              var total =  "$" + total;
              $("#totalPrice").html(total);
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
          success: function(data){
              containerId = "#value-" + id;
              value = $(containerId).val();
              if (value > 0) {
                $(containerId).val(parseInt(value) - 1);  
              } else {
                $(containerId).val(0);  
              }

              //update cart
              var data = JSON.parse(data);
              var total = data.cart;
              var total =  "$" + total;
              $("#totalPrice").html(total);
            
          },
          error:function(){
              alert("failure");

              $("#result").html('There is error while submit');
          }
      });
})

</script>