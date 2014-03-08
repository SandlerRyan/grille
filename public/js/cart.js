// Ajax call to add item
$(".addItem").click(function(){
  var id = this.id.split('-')[1];
  url = "/cart/increment/" + id;
  $.ajax({
      url: url,
      type: "get",
      success: function(data){
          var data = JSON.parse(data);
          containerId = "#value-" + id;
          //update counter
          var qty = $(containerId).text();
          $(containerId).text(parseInt(qty) + 1);
          //update cart footer
          var total = "$" + data.cart;
          $("#totalPrice").html(total);
          $(SUBMIT_BUTTON).removeAttr('disabled');
      },
      error:function(){
          alert("failure");
          $("#result").html('There was an error during submission');
      }
    });
});

// Ajax call to remove item
$(".removeItem").click(function(){
  var id = this.id.split('-')[1];
  url = "/cart/decrement/" + id;
  $.ajax({
      url: url,
      type: "get",
      success: function(data){
          // update counter
          containerId = "#value-" + id;
          var qty = $(containerId).text();
          if (qty > 0) {
            $(containerId).text(parseInt(qty) - 1);
          } else {
            $(containerId).text(0);
          }
          //update cart and gray out checkout button if total is zero
          var data = JSON.parse(data);
          var total = data.cart;
          if (parseInt(total) == 0) {
            $(SUBMIT_BUTTON).attr('disabled','disabled');
          }
          var total =  "$" + total;
          $("#totalPrice").html(total);

          //decrement any addons that have been removed by item removal
          check_addons(id);
      },
      error: function(){
          alert("failure");

          $("#result").html('There was an error during submission');
      }
  });
})

// Ajax call to add an addon
$(".addAddon").click(function(){
  var info = this.id.split("-");
  var addon_id = info[1];
  var item_id = info[2];
  $.ajax({
      url: '/cart/increment_addon/' + addon_id + '/' + item_id,
      type: 'get',
      success: function(data){
        // if there are fewer items than the addon you're trying to add
        // the back end will return success but will not update the cart,
        // so do not update counters
        var data = JSON.parse(data);

        // check that there are not more addons than items
        if (data.validated == true) {
          containerID = '#value-' + addon_id + '-' + item_id;
          // update counter
          var qty = $(containerID).text();
          $(containerID).text(parseInt(qty) + 1);
          // update cart footer
          var total = '$' + data.cart;
          $("#totalPrice").html(total);
        }
      },
      error:function(){
        alert("failure");
        $("#result").html('There was an error during submission');
      }
  });
});

// Ajax call to remove an addon
$(".removeAddon").click(function(){
  var info = this.id.split("-");
  var addon_id = info[1];
  var item_id = info[2];
  $.ajax({
      url: '/cart/decrement_addon/' + addon_id + '/' + item_id,
      type: 'get',
      success: function(data){
          // update counter
          containerID = "#value-" + addon_id + '-' + item_id;
          var qty = $(containerID).text();
          if (qty > 0) {
            $(containerID).text(parseInt(qty) - 1);
          } else {
            $(containerID).text(0);
          }
          //update cart and gray out checkout button if total is zero
          var data = JSON.parse(data);
          var total = data.cart;
          var total =  "$" + total;
          $("#totalPrice").html(total);
      },
      error: function(){
          alert("failure");
          $("#result").html('There was an error during submission');
      }
  });
})

// Ajax call to clear cart and zero out item totals
$("#clearCart").click(function() {
  var url = "/cart/empty_cart";
  $.ajax({
    url: url,
    type: "get",
    success: function(data){
        // update cart
        var data = JSON.parse(data);
        var total = data.cart;
        var total =  "$" + total;
        $("#totalPrice").html(total);

        // clear all quantity values without having to refresh the page
        $(".itemQuantity").each(function(i, obj){
          $(obj).text(0);
        })
        $(".addonQuantity").each(function(i, obj){
          $(obj).text(0);
        })
        // disable checkout button
        $(SUBMIT_BUTTON).attr('disabled','disabled');
    },
    error:function(){
        alert("Sorry, something bad happened.");
    }
  });
})

// Called when an item is decremented to ensure that all that items
// addons do not have quantities greater than the item
// (backend deduction of excess items is handled by the decrement function)
function check_addons(item_id) {
  var item_qty = parseInt($('#value-' + item_id).text());

  // select all addons belonging to the item
  var item_addons = $("." + item_id).find(".addonQuantity");
  // iterate through the addons
  item_addons.each(function(i, obj){
    var addon_qty = parseInt($(obj).text());

    // set any excess addon quantities equal to item quantity
    if (addon_qty > item_qty){
      $(obj).text(String(item_qty));
    }
  });
}





