    <!-- Top Navigation Bar -->
    <!-- <div class="sb-navbar sb-slide"> -->

      <!-- Left Slidebar control -->
      <div class="button alert sb-toggle-left">
<!--    <div class="navicon-line"></div>
        <div class="navicon-line"></div>
        <div class="navicon-line"></div> -->
        In-Stock Side Bar
      </div>

    <!-- </div> -->
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

<script type="text/javascript" src="{{ URL::asset('js/dashboard.js') }}"></script>



<script id="tmpl-orders" type="text/template">
  
  <ul class="clearing-thumbs" data-clearing="">

        <%
          // repeat orders
          _.each(orders, function(order) {
        %>
        <li>

        <% if (order.venmo_id != 0) { %>

          <div class="large-12 columns">
             <div class="panel" id="<%= order.id %>">
                <div style="float:left;"><img border="0" src="/img/venmo.png" width="90px"></div>
                <div align="right">
                   <h4>$15.50</h4>
                </div>
                <br>
                <h5>Nuseir Yassin</h5>
                <h6>ID:10</h6>
                <table>
                   <thead>
                      <tr>
                         <th width="120">Item</th>
                         <th width="80">Quantity</th>
                         <th width="150">Notes</th>
                      </tr>
                   </thead>
                   

                   <tbody>

                      <%
                        // repeat order items
                        _.each(order.item_orders, function(order.item_orders) {
                      %>

                        <tr>
                           <td>The Dean Evelyn Hammelt</td>
                           <td>2</td>
                           <td>undefined</td>
                        </tr>

                      <%
                        }); // end repeat order items
                      %>

                   </tbody>

                </table>

                <ul class="button-group">
                   <li><a href="javascript:void(0)" id="<%= order.id %>" class="small button success cooked">Cooked</a></li>
                   <li><a href="javascript:void(0)" id="<%= order.id %>" class="small button success picked">Picked-Up</a></li>
                   <li><a href="javascript:void(0)" id="<%= order.id %>" class="small button alert refund">Refund Order</a></li>
                </ul>
             </div>
          </div>


        <% } else { %>



        <% }  %>

        </li>

        <%
          }); // end repeat orders
        %>

  </ul>
</script>
