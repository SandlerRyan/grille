   
    <!-- Top Navigation Bar -->
    <div class="sb-navbar sb-slide">
    
      <!-- Left Slidebar control -->
      <div class="sb-toggle-left">
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
              {{ $item->name}} 

                  <label class="switch-light switch-ios" style="width: 100px" onclick="">
                    <input type="checkbox" />
                    <span>
                    Available?
                      <span>No</span>
                      <span>Yes</span>
                    </span>

                    <a></a>
                  </label>


            @else
              {{ $item->name }} 


                  <label class="switch-light switch-ios" style="width: 100px" onclick="">
                    <input type="checkbox" />
                    <span>
                    Available?
                      <span>No</span>
                      <span>Yes</span>
                    </span>

                    <a></a>
                  </label>

            @endif

          </li>
      
        @endforeach

      </ul>

      
    </div><!-- /.sb-slidebar .sb-left -->


<div class="row">


<div id="show_orders">


</div>


<ul class="clearing-thumbs" data-clearing>

  <li>
    <div class="large-12 columns">
      <div class="panel" id="order.id">

        <!-- <div align="right"><h4>$40.0</h4></div> -->
        <div style="float:left;"><h4 style="color:green;">Pick-Up</h4></div>
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



<!-- @foreach($items as $item)
	
	@if ($item->available) 
		{{ $item->name}} - available 

		<a href="javascript:void(0)" class="mark_item_unavailable" id="{{$item->id}}">
			Mark as unavailable
		</a>
	@else
		{{ $item->name }} - unavailable 
		<a href="javascript:void(0)" class="mark_item_available" id="{{$item->id}}">
			Mark as available
		</a>
	@endif
	<br/>
@endforeach -->

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
    	
    	$("#show_orders").html(html);
        setTimeout(function(){get_new_orders();}, 5000);
    });
 }
  function generate_html_content(data) {
	htmlcontent = ""
	itemshtml = ""
	data.cart.forEach(function(order) {

		order.item_orders.forEach(function(item) {
				console.log("IM HERE!")
				itemshtml += item.name + "</br>" + item.description;
			}) 
		htmlcontent += 
		"<div style='width: 300px; height: 300px; background-color: white; border: 1px solid black;float: left; margin-right: 5%; margin-bottom: 5%;' class='order' id='" + 
			order.id + 
			"'>" + 	
			"<div id='orderInfo'>" + 
				order.id + 
				"<div id='order_user'>" +
					order.user.name +
				"</div>" + 
			"</div>" +
			"<div id='items'>" 
				+ 
				itemshtml
				+
			"</div>" +
			"<a href='javascript:void(0)' class='completed' id='" + order.id + "'>Mark As Complete</a><br/>" + 
			"<a href='javascript:void(0)' class='refund' id='" + order.id + "'>Refund Order</a>" + 

		"</div>";
	})

	return htmlcontent;
  }
	
$( document ).on( 'click', '.completed', function () {
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
          alert("Sorry, something bad happened.");
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

	$.ajax({
      url: url,
      type: "post",
      success: function(data){
          //TODO: REMOVE GRAY FROM BUTTON AND CHANGE THE BUTTON TO MARK UNAVAILABLE
          console.log("good")
      },
      error:function(){
          alert("Sorry, something bad happened.");
      }
    });
})
</script>
