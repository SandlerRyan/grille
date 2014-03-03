    <!-- Top Navigation Bar -->
    <div class="sb-navbar sb-slide">
    
      <!-- Left Slidebar control -->
      <div class="button sb-toggle-left">
        <div class="navicon-line"></div>
        <div class="navicon-line"></div>
        <div class="navicon-line"></div>
      </div>

    </div>
    <!-- Left Slidebar -->
    <div class="sb-slidebar sb-left"> 

      <!-- Lists in Slidebars -->
      <ul class="sb-menu">


        @foreach($items as $item)
          <li>

            @if ($item->available) 
    

            <button style="width: 100%;" class="button success mark_item_unavailable" id="{{$item->id}}">
              {{ $item->name}}

            </button>



            @else
              <button style="width: 100%;" class="button alert mark_item_available" id="{{$item->id}}">
              {{ $item->name }} 

              </button>

            @endif

          </li>
      
        @endforeach

      </ul>

      
    </div>

<div class="row">


<div id="show_orders">


</div>


<ul class="clearing-thumbs" data-clearing>

  <li>
    <div class="large-12 columns">
      <div class="panel" id="order.id">

        <!-- <div align="right"><h4>$40.0</h4></div> -->
        <div style="float:left;"><h4>Pick-Up</h4></div>
        <div align="right"><h4>$55.0</h4></div>

        <br/>

        <h5>John Doe</h5>
        <h6>ID: 11234567890</h6>

        <table>
          <thead>
            <tr>
              <th width="150">Item</th>
              <th width="150">Description</th>
            </tr>
          </thead>
          <tbody>
          <tr>
            <td>Hamburger</td>
            <td>No meat please</td>
          </tr>
          <tr>
            <td>French fries</td>
            <td>Baked, not fried</td>
          </tr>
        </tbody>
        </table>

          <ul class="button-group">
            <li><a href="#" class="small button success">Cooked</a></li>
            <li><a href="#" class="small button success">Paid and Picked-Up</a></li>
          </ul>

          <br/>

      </div>
    </div>
  </li>

  <li>
    <div class="large-12 columns">
      <div class="panel" id="order.id">

        <div style="float:left;"><img border="0" src="/img/venmo.png" width="90px"></div>
        <div align="right"><h4>$55.0</h4></div>
        <br/>


        <h5>John Doe</h5>
        <h6>ID: 11234567890</h6>

        <table>
          <thead>
            <tr>
              <th width="150">Item</th>
              <th width="150">Description</th>
            </tr>
          </thead>
          <tbody>
          <tr>
            <td>Hamburger</td>
            <td>No meat please</td>
          </tr>
          <tr>
            <td>French fries</td>
            <td>Baked, not fried</td>
          </tr>
        </tbody>
        </table>

          <ul class="button-group">
            <li><a href="#" class="small button success">Cooked</a></li>
            <li><a href="#" class="small button success">Picked-Up</a></li>
            <li><a href="#" class="small button alert">Refund Order</a></li>
          </ul>

          <br/>

      </div>
    </div>
  </li>

</ul>


</div>

<script>

 
 $(document).ready(function () {
    get_new_orders();
  });
 
 function get_new_orders() {
    var feedback =
    $.ajax({
        type: "POST",
        url: "/get_new_orders",
        async: false
    }).complete(function(data){
    	data = JSON.parse(data.responseText);
    	console.log(data.cart)
    	$("#show_orders").html("");
    	html = generate_html_content(data);
    	
    	$(".clearing-thumbs").html(html);
        setTimeout(function(){get_new_orders();}, 5000);
    });
 }
  var getTD = function(itemName) {
    return "<td>" + itemName + "</td>";
  }
  var getTR = function(rowItems) {
   return "<tr>" + rowItems + "</tr>"; 
  }
  var addButtons = function(order) {
    return "<ul class='button-group'>" + 
            "<li><a href='javascript:void(0)' id='" + order.id + "' class='small button success cooked'>Cooked</a></li>" + 
            "<li><a href='javascript:void(0)' id='" + order.id + "' class='small button success picked'>Picked-Up</a></li>" +
            "<li><a href='javascript:void(0)' id='" + order.id + "' class='small button alert refund'>Refund Order</a></li>" +
            "</ul>"
  }
  var AddTable = function(order) {
    var rows = ""
    var head = ""
    order.item_orders.forEach(function(item) {
        rows += getTR(getTD(item.name) + getTD(item.notes));
    }) 
    rows = "<tbody>" + rows + "<tbody>"
    head =  "<thead><tr><th width='150'>Item</th><th width='150'>Description</th>" +
            "</tr></thead>"
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

  
$( document ).on( 'click', '.cooked', function () {
    console.log($(this).attr('id'))
    var url = "/mark_as_cooked/" + $(this).attr('id');
  $.ajax({
      url: url,
      type: "post",
      success: function(data){
          // update cart
          console.log("good")
          $(this).html("heh");
      },
      error:function(){
          alert("Sorry, something bad happened.");
      }
    });
});
	
$( document ).on( 'click', '.picked', function () {
    console.log($(this).attr('id'))
    var url = "/mark_as_fulfilled/" + $(this).attr('id');
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

$( document ).on( 'click', '.refund', function () {
    console.log($(this).attr('id'))
    var url = "/refund_order/" + $(this).attr('id');
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


$('.mark_item_unavailable').click(function() {
	console.log("hello")
	var url = "/mark_as_unavailable/" + $(this).attr('id');

	$.ajax({
      url: url,
      type: "post",
      success: function(data){
          //TODO:  MAKE THE DIV GRAY AND CHANGE THE BUTTON TO MARK AVAILABLE
          console.log("good")
      },
      error:function(){
          alert("Sorry, something bad happened.");
      }
    });
})
$('.mark_item_available').click(function() {
	console.log("hello")
	var url = "/mark_as_available/" + $(this).attr('id');
  var id = $(this).attr('id');
	$.ajax({
      url: url,
      type: "post",
      success: function(data){
          //TODO: REMOVE GRAY FROM BUTTON AND CHANGE THE BUTTON TO MARK UNAVAILABLE
          console.log("good")
          
          $(id).removeClass("alert");
          $(id).removeClass("success");
          console.log($(id)); 
      },
      error:function(){
          alert("Sorry, something bad happened.");
      }
    });
})
</script>
