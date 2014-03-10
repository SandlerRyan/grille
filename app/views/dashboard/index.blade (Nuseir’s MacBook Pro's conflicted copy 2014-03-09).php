<div class="row">


<div id="show_orders">

<ul class="clearing-thumbs" data-clearing>

</ul>

</div>

</div>

<script type="text/javascript" src="{{ URL::asset('js/dashboard.js') }}"></script>
<script type="text/javascript" src="http://documentcloud.github.com/underscore/underscore-min.js"></script>
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
                      %>
                          <tr>
                           <td><%= item.name %></td>
                           <td><%= item.id %></td>
                           <td><%= item.notes %></td>
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

        </li>

        <%
          }); // end repeat orders
        %>

  </ul>
  
</script>


