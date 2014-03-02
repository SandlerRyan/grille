   
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


    <div style='width: 300px; height: 300px; background-color: white; border: 1px solid black;float: left; margin-right: 5%; margin-bottom: 5%;' class='order' id='" + 
      order.id + 
      "'> 
      <div id='orderInfo'> 
        12345
        <div id='order_user'> 
          Sample User
        </div>
      </div> 
      <div id='items'>

        Item 1 <br/> 
        This is a description

        Item 2 <br/> 
        This is a description

        Item 3 <br/> 
        This is a description

      </div>
      <a href='javascript:void(0)' class='completed' id="1234">Mark As Complete</a><br/>
      <a href='javascript:void(0)' class='refund' id="1234">Refund Order</a> 

    </div>



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
