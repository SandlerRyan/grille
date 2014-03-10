<div class="row">
<h3>Cancelled Orders</h3>
<br/>

<div id="show_orders">


	</div>
</div>

<div class="row">
  <div class="large-12 columns">
  </div>
  <div class="large-6 columns">
      <ul class="inline-list right">
        <li><a class="button" href="/dashboard/">See incoming orders</a></li>
        <li><a class="button" href="/dashboard/filled_orders">See fulfilled orders</a></li>
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
              <div style="float:left;"><h4 style="color:red; font-weight: 200;">Cancelled</h4></div>

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
                  <% if (!order.refunded && order.venmo_id != 0) { %>
                  	<li><a href="javascript:void(0)" id="<%= order.id %>" class="small button alert refund">Refund</a></li>
                  <% } %>
                </ul>
             </div>
          </div>

        </li>

        <%
          }); // end repeat orders
        %>

  </ul>

</script>