/**
* AJAX functions for getting new orders
* and controlling item availability, order status, etc.
*/

// get new orders
$(document).ready(function () {

var tmpl = $('#tmpl-orders').html();

get_new_orders(tmpl);
available();
unavailable();
});

// contacts the server to get new orders every 5000 millisecs
function get_new_orders(tmpl) {
  var feedback =
  $.ajax({
      type: "POST",
      url: "/dashboard/get_new_orders",
      async: false
  }).complete(function(data){

    data = JSON.parse(data.responseText);

    $("#show_orders").html("");
    var compiledtmpl = _.template(tmpl, {orders: data.cart})
    $("#show_orders").html(compiledtmpl);

    //repeat every 5 seconds.
    setTimeout(function(){get_new_orders(tmpl);}, 5000);

  });
}

// ajax call to indicate item has been cooked and send text to user
$( document ).on( 'click', '.cooked', function () {
    var id = $(this).attr('id');
    var url = "/dashboard/mark_as_cooked/" + $(this).attr('id');
    var element = $(this);
  $.ajax({
      url: url,
      type: "post",
      success: function(){
          // update cart
          console.log("cooked")
          $(element).closest('li').text("Cooked!");
      },
      error:function(){
          alert("Sorry, something bad happened.");
      }
    });
});

// ajax call to indicate that item has been picked up and order is fulfilled
$( document ).on( 'click', '.picked', function () {
    console.log($(this).attr('id'))
    var url = "/dashboard/mark_as_fulfilled/" + $(this).attr('id');
    var element = $(this);
  $.ajax({
      url: url,
      type: "post",
      success: function(data){
          // update cart
          console.log("good")
          $(element).closest('li').text("This order is complete!");
      },
      error:function(){
          alert("Sorry, something bad happened.");
      }
    });
});

// ajax call to refund users who have paid with venmo
$( document ).on( 'click', '.refund', function () {
    console.log($(this).attr('id'))
    var url = "/dashboard/refund_order/" + $(this).attr('id');
  $.ajax({
      url: url,
      type: "post",
      success: function(data){
          // update cart
          console.log("order refunded and has been cancelled")
      },
      error:function(){
          alert("Sorry, something went wrong.");
      }
    });
});

// ajax call to cancel a order if it has not been picked up or if item has run out
$( document ).on( 'click', '.cancel', function () {
    console.log($(this).attr('id'))
    var url = "/dashboard/cancel/" + $(this).attr('id');
    var element = $(this);
  $.ajax({
      url: url,
      type: "post",
      success: function(data){
          // update cart
          console.log("good")
          $(element).closest('li').text("Order cancelled!");
      },
      error:function(){
          alert("Sorry, something bad happened.");
      }
    });
});

// ajax call to mark an item unavailable when it runs out
function unavailable () {
  $( document ).on('click', '.mark_item_unavailable', function () {
  console.log("mark unav")
  var id = $(this).attr('id');
  var url = "/dashboard/mark_as_unavailable/" + id;

  $.ajax({
      url: url,
      type: "post",
      success: function(data){
          //TODO:  MAKE THE DIV GRAY AND CHANGE THE BUTTON TO MARK AVAILABLE
          id = "#" + id;
          $(id).removeClass('success');
          $(id).addClass('alert');
          $(id).removeClass('mark_item_unavailable');
          $(id).addClass('mark_item_available');
          available ();
          // $(id).removeClass('mark_item_available');

      },
      error:function(){
          alert("Sorry, something bad happened.");
      }
    });
  });
}

// ajax call to mark an item available when it is back in stock
function available () {
  $( document ).on('click', '.mark_item_available', function () {
  console.log("mark av")
  var url = "/dashboard/mark_as_available/" + $(this).attr('id');
  var id = $(this).attr('id');
  $.ajax({
      url: url,
      type: "post",
      success: function(data){

          id = "#" + id;
          $(id).removeClass('alert');
          $(id).addClass('success');
          $(id).removeClass('mark_item_available');
          $(id).addClass('mark_item_unavailable');
          unavailable ();
      },
      error:function(){
          alert("Sorry, something bad happened.");
      }
    });
  });
}
