   
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

<script type="text/javascript" src="{{ URL::asset('js/dashboard.js') }}"></script>