<!-- <div id="result"></div> -->
<div class="row">

  @foreach($menu as $category=>$items)
    <h3>{{$category}}</h3>

    <table>
      <tr>
        <th width="200">Item</th>
        <th width="50">Add</th>
        <th width="50">Quantity</th>
        <th width="50">Remove</th>
        <th width="50">Price</th>
      </tr>
    @foreach($items as $item)
    <tr>

      <td>
    	 <b>{{{ $item->name }}}</b> <br/>
       {{{ $item->description}}}
      </td>

      <td>
        <button type="button" class="addItem" id="{{{$item->id}}}"> + </button>
        <?php $qty = Cart::find($item->id);
          if ($qty) {
            $qty = $qty->quantity;
          } else {
            $qty = 0;
          }
        ?> 
      </td>

      <td>
        <input type="text" size="1" class="itemQuantity" id="value-{{$item->id}}" value="{{{ $qty }}}" />
      </td>
      
      <td>
        <button type="button" class="removeItem" id="{{{$item->id}}}"> - </button>
  	  </td>

<!--       <td>
    	 {{{ $item->description}}}
      </td>
 -->
      <td>
    	 ${{{ $item->price}}}
      </td>

    </tr>
    	<!-- <br/> -->
    @endforeach
  </table>
  @endforeach

</div>

  <!-- Call to Action Panel -->
  <div class="row">
      <div class="large-12 columns">
      
        <div class="panel">

        <h4>Your total is: ${{{Cart::total()}}} </h4>
        <!-- <div id="totalPrice">${{{Cart::total()}}}</div> -->

        <button class="button alert round disabled">Checkout</button>
        
        <button type="button" class="button alert round">Clear Cart</button> 



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
          console.log("clicked");
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
                  $("#result").html('There is error while submit');
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

    </div>
  </div>


