<!-- End Header and Nav -->
  <div class="button alert sb-toggle-left" style="background-color:gray">
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
    <ul class="clearing-thumbs" data-clearing>
    </ul>
  </div>
</div>

<div class="row">
  <div class="large-12 columns">
  </div>
  <div class="large-6 columns">
      <ul class="inline-list right">
        <li><a class="button" style="background-color:gray" href="/dashboard/">Incoming Orders</a></li>
        <li><a class="button" style="background-color:gray" href="/dashboard/filled_orders">Fulfilled orders</a></li>
        <li><a class="button" style="background-color:gray" href="/dashboard/cancelled_orders">Cancelled orders</a></li>
      </ul>
  </div>
</div>

<script type="text/javascript" src="{{ URL::asset('js/dashboard.js') }}"></script>
<script type="text/javascript" src="http://documentcloud.github.com/underscore/underscore-min.js"></script>
<script type="text/javascript">
  // get new orders
$(document).ready(function () {

var tmpl = $('#tmpl-orders').html();

get_orders(tmpl, 'new');
available();
unavailable();
});

</script>


<script id="tmpl-orders" type="text/template">

    <ul class="clearing-thumbs" data-clearing>

        <%
          _.each(orders, function(order) {
        %>
        <li>
          <div class="large-12 columns">
             <div class="panel" id="<%= order.id %>">
        <% if (order.venmo_id != 0) { %>
          <div style="float:left;"><h4 style="color: #3D95CE; font-weight: 200;">Venmo</h4></div>

        <% } else { %>
          <div style="float:left;"><h4 style="font-weight: 200;">Pickup</h4></div>

        <% }  %>

                <div align="right">
                   <h4>$<%= order.cost %></h4>
                </div>
                <br>
                <h5><%= order.user.name %></h5>
                <h6>ID: <%= order.id %></h6>
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
                        _.each(order.item_orders, function(item) {
                          ////////////////////
                          console.log(item);
                          ////////////////////
                      %>
                        <tr>
                           <td><%= item.name %></td>
                           <td><%= item.pivot.quantity %></td>
                           <td><%= item.pivot.notes %></td>
                        </tr>
                      <%
                        _.each(item.addons, function(addon) {
                      %>
                        <tr>
                          <td>&nbsp + <%= addon.name %></td>
                          <td><%= addon.pivot.quantity %></td>
                          <td></td>
                        </tr>
                      <% }); %>

                      <%
                        }); // end repeat order items
                      %>

                   </tbody>

                </table>

                <ul class="button-group">
                  <% if (order.cooked == 0) { %>
                    <li><a href="javascript:void(0)" id="<%= order.id %>" class="small button success cooked">Cooked</a></li>
                  <% } else { %>
                    <li>Cooked!</li>
                  <% } %>
                  <li><a href="javascript:void(0)" id="<%= order.id %>" class="small button success picked">Picked Up</a></li>
                  <% if (!order.refunded && order.venmo_id != 0) { %>
                    <li><a href="javascript:void(0)" id="<%= order.id %>" class="small button alert refund">Refund</a></li>
                  <% } %>
                  <li><a href="javascript:void(0)" id="<%= order.id %>" class="small button alert cancel"
                    style="background-color: red">Cancel</a></li>
                </ul>
             </div>
          </div>

        </li>

        <%
          }); // end repeat orders
        %>

  </ul>
</script>


