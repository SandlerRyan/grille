/**
* Functions for injecting HTML for every new order
*/
var getTD = function(itemName) {
  return "<td>" + itemName + "</td>";
}
var getTR = function(rowItems) {
 return "<tr>" + rowItems + "</tr>";
}
var addButtons = function(order) {
  if (order.venmo_id != 0) {
  return "<ul class='button-group'>" +
          "<li><a href='javascript:void(0)' id='" + order.id + "' class='small button success cooked'>Cooked</a></li>" +
          "<li><a href='javascript:void(0)' id='" + order.id + "' class='small button success picked'>Picked-Up</a></li>" +
          "<li><a href='javascript:void(0)' id='" + order.id + "' class='small button alert refund'>Refund Order</a></li>" +
          "</ul>"
  }
  else {
    return "<ul class='button-group'>" +
          "<li><a href='javascript:void(0)' id='" + order.id + "' class='small button success cooked'>Cooked</a></li>" +
          "<li><a href='javascript:void(0)' id='" + order.id + "' class='small button success picked'>Paid and Picked-Up</a></li>" +
          "</ul>"
  }
}

var AddTable = function(order) {
  var rows = ""
  var head = ""
  order.item_orders.forEach(function(item) {

      rows += getTR(getTD(item.name) + getTD(item.pivot.quantity) + getTD(item.notes));
      item.addons.forEach(function(addon) {
        rows += getTR(getTD("&emsp; <i>+" + addon.name + "</i>") + getTD(addon.pivot.quantity) + getTD(" "));
      })
  })
  rows = "<tbody>" + rows + "<tbody>"
  head =  "<thead><tr>" +
          "<th width='120'>Item</th><th width='80'>Quantity</th>" +
          "<th width='150'>Notes</th></tr></thead>"
  var content = head + rows;
  return "<table>" + content + "</table>";
}

var addMainWrapper = function(content, orderID) {
    return "<li><div class='large-12 columns'>" +
           "<div class='panel' id='" + orderID + "'>" +
           content +
           "</div>" +
           "</li></div>";
}
var addVenmoHeader= function(order) {
  return "<div style='float:left;'><img border='0'" +
          "src='/img/venmo.png' width='90px'></div>" +
          "<div align='right'><h4>$" + order.cost + "</h4></div>"+
          "<br/>" +
          "<h5>" + order.user.name + "</h5>" +
          "<h6>ID:" + order.id + "</h6>";
}
var addPickUpHeader = function(order) {
  return "<div style='float:left;'><h4>Pick-Up</h4>" +
          "</div>" +
          "<div align='right'><h4>$" + order.cost + "</h4></div>"+
          "<br/>" +
          "<h5>" + order.user.name + "</h5>" +
          "<h6>ID:" + order.id + "</h6>";
}

// to create new order boxes
function generate_html_content(data) {
  var htmlcontent = ""
  var itemshtml = ""
  var main = ""
  data.cart.forEach(function(order) {

    htmlcontent = ""
    if(order.venmo_id != 0) {
      htmlcontent += addVenmoHeader(order);
    } else {
      htmlcontent += addPickUpHeader(order);
    }
    htmlcontent += AddTable(order);
    htmlcontent += addButtons(order);
    main += addMainWrapper(htmlcontent, order.id);
  })
return main;
}



/**
* AJAX functions for getting new orders
* and controlling item availability, order status, etc.
*/

// get new orders
$(document).ready(function () {
get_new_orders();
available();
unavailable();
});

// contacts the server to get new orders every 5000 millisecs
function get_new_orders() {
  var feedback =
  $.ajax({
      type: "POST",
      url: "/dashboard/get_new_orders",
      async: false
  }).complete(function(data){
    data = JSON.parse(data.responseText);
    $("#show_orders").html("");
    html = generate_html_content(data);

    $(".clearing-thumbs").html(html);
      setTimeout(function(){get_new_orders();}, 5000);
  });
}

// ajax call to indicate item has been cooked and send text to user
$( document ).on( 'click', '.cooked', function () {
    var id = $(this).attr('id');
    var url = "/dashboard/mark_as_cooked/" + $(this).attr('id');
  $.ajax({
      url: url,
      type: "post",
      success: function(data){
          // update cart
          $('#' + id).attr('disabled','disabled');
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
  $.ajax({
      url: url,
      type: "post",
      success: function(data){
          // update cart
          console.log("good")
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
          //TODO: REMOVE GRAY FROM BUTTON AND CHANGE THE BUTTON TO MARK UNAVAILABLE
          id = "#" + id;
          $(id).removeClass('alert');
          $(id).addClass('success');
          $(id).removeClass('mark_item_available');
          $(id).addClass('mark_item_unavailable');
          unavailable ();

          console.log($(id));
      },
      error:function(){
          alert("Sorry, something bad happened.");
      }
    });
  });
}
