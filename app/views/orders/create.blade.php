<!-- Global header/footer -->
<div id="s">
  <div class="row">
    <div class="large-12 columns">
      <div class="panel">
        <h4>Your total is: <div id="totalPrice"> ${{{Cart::total()}}} </div> </h4>
        <ul class="button-group round even-2">
          <li><button id="checkout" class="button success round" disabled>Checkout</button></li>
          <li><button id="clearCart" class="button alert round">Clear Cart</button></li>
        </ul>
        <br/>
      </div>
    </div>
  </div>
</div>

<!-- Main body of menu -->
<div class="row">
  @if($err_messages)
    <h5><font color="red">{{$err_messages}}</font></h5>
  @endif

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
    <?php //get item quantity
        $this_item = Cart::find($item->id);
        $qty = ($this_item ? $this_item->quantity : 0); ?> 
    
    <tr class="{{ $item->id }}">
      <td>
          <b>{{{ $item->name }}}</b> 
          @if(!$item->available) <i>(unavailable)</i>@endif
          <br/>
          {{{ $item->description}}}
          @if($item->addon != '[]')
            <div><i>Addons: </i>
              <table>
                @foreach($item->addon as $addon)
                <tr>
                  <td>
                  {{{ $addon->name }}}
                  {{{ $addon->price }}}
                  </td>
                  <td>
                    <button type="button" class="addAddon" id="add-{{$addon->id}}-{{ $item->id }}"
                      @if(!$item->available || !$addon->available) disabled @endif>+</button>
                  </td>
                  <td>
                    <?php 
                      if ($this_item){
                      $this_addon = Cart::find_addon($addon->id, $this_item);
                      $addon_qty = ($this_addon ? $this_addon->quantity : 0);
                      }
                      else $addon_qty = 0; 
                    ?>
                    <div class="addonQuantity" id="value-{{ $addon->id }}-{{ $item->id }}">{{ $addon_qty }}</div>
                  </td>
                  <td>
                    <button type="button" class="removeAddon" id="remove-{{$addon->id}}-{{ $item->id }}"
                      @if(!$item->available || !$addon->available) disabled @endif>-</button>
                  </td>
                </tr>
                @endforeach
            </table>
            </div>
          @else
          <div></div>
          @endif
          </td>
          <td>
            <button type="button" class="addItem" id="add-{{ $item->id }}"
              @if(!$item->available) disabled @endif> + </button>
          </td>
          <td>
            <div class="itemQuantity" id="value-{{ $item->id }}">{{ $qty }}</div>
          </td>          
          <td>
            <button type="button" class="removeItem" id="remove-{{ $item->id }}" 
              @if(!$item->available) disabled @endif> - </button>
      	  </td>
          <td>
        	 ${{{ $item->price}}}
          </td>
        </tr>
      @endforeach
    </table>
  @endforeach

</div>

<div id="result"></div>

<!-- cart.js handles all ajax calls to the cart -->
<script type="text/javascript" src="{{ URL::asset('js/cart.js') }}"></script>
<script>
 
  //  $(window).bind("load", function () {
  //     var footer = $("#footer");
  //     var pos = footer.position();
  //     var height = $(window).height();
  //     height = height - pos.top;
  //     height = height - footer.height();
  //     if (height > 0) {
  //         footer.css({
  //             'margin-top': height + 'px'
  //         });
  //     }
  // });

var SUBMIT_BUTTON = '#checkout';

// Set the checkout button status when the page is loaded
$(document).ready(function () {
  // initialize the button as disabled
  // remove dollar sign from total
  var total = $('#totalPrice').text().substr(2);
  if (parseInt(total) != 0) {
    $(SUBMIT_BUTTON).removeAttr('disabled');
  }
});


// enable the checkout button whenver there are items in the cart
 $(SUBMIT_BUTTON).click(function () {
    $(this).attr('disabled', 'disabled');
    window.location = '/checkout';
 });

$(document).ready(function() {  
	var stickyNavTop = $('#s').offset().top;  
	  
	var stickyNav = function() {  
  	var scrollTop = $(window).scrollTop();  
  	       
  	if (scrollTop > stickyNavTop) {   
  	    $('#s').addClass('sticky');  
  	} else {  
  	    $('#s').removeClass('sticky');   
  	}  
  };  
  
stickyNav();  
  
$(window).scroll(function() {  
    stickyNav();  
	});  
});  
</script>