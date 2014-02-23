
<div id="result"></div>

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


<button class="submit" disabled>Checkout</button>
<br/>
        

<button type="button" class="clearCart">Clear Cart</button> 

<div id="totalPrice">${{{Cart::total()}}}</div>



<script>
var SUBMIT_BUTTON = 'button.submit';

// Set the checkout button status when the page is loaded
$(document).ready(function () {
  // initialize the button as disabled

  // remove dollar sign from total
  var total = $('#totalPrice').text().substr(1);
  if (parseInt(total) != 0) {
    $(SUBMIT_BUTTON).removeAttr('disabled');
  }
});


// Ajax call to add item
$(".addItem").click(function(){
  var id = this.id;
  url = "/increment/" + id;
  $.ajax({
      url: url,
      type: "get",
      success: function(data){
          //update counter
          containerId = "#value-" + id;
          value = $(containerId).val();
          $(containerId).val(parseInt(value) + 1);
          //update cart
          var data = JSON.parse(data);
          var total = data.cart;
          var total =  "$" + total;
          $("#totalPrice").html(total);
          $(SUBMIT_BUTTON).removeAttr('disabled');
      },
      error:function(){
          alert("failure");
          $("#result").html('There was an error during submission');
      }
  });
})

// Ajax call to remove item
$(".removeItem").click(function(){
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

          //update cart and gray out checkout button if total is zero
          var data = JSON.parse(data);
          var total = data.cart;
          if (parseInt(total) == 0) {
            $(SUBMIT_BUTTON).attr('disabled','disabled');
          }
          var total =  "$" + total;
          $("#totalPrice").html(total);

      },
      error:function(){
          alert("failure");

          $("#result").html('There was an error during submission');
      }
  });
})

// Ajax call to clear cart and zero out item totals
$(".clearCart").click(function() {
  var url = "/empty_cart";
  $.ajax({
    url: url,
    type: "get",
    success: function(data){
        // update cart
        var data = JSON.parse(data);
        var total = data.cart;
        var total =  "$" + total;
        $("#totalPrice").html(total);
        
        // clear all inputs without having to refresh the page
        $(".itemQuantity").each(function(i, obj){
          $(obj).val(0);
        })
        // disable checkout button
        $(SUBMIT_BUTTON).attr('disabled','disabled');
    },
    error:function(){
        alert("Sorry, something bad happened.");
    }
  });
})

// enable the checkout button whenver there are items in the cart
 $(SUBMIT_BUTTON).click(function () {
    console.log("clicked");
    $(this).attr('disabled', 'disabled');
    window.location = '/checkout';
 });
</script>