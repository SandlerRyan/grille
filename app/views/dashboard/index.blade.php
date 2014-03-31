@extends('layouts.admin')

@section('content')

    <style scoped>

        .button-success,
        .button-error,
        .button-warning,
        .button-secondary {
            color: white;
            border-radius: 4px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }

        .button-success {
            background: rgb(28, 184, 65); /* this is a green */
        }

        .button-error {
            background: rgb(202, 60, 60); /* this is a maroon */
        }

        .button-warning {
            background: rgb(223, 117, 20); /* this is an orange */
        }

        .button-secondary {
            background: rgb(66, 184, 221); /* this is a light blue */
        }

    </style>
<!-- End Header and Nav -->
  <div class="button-secondary pure-button sb-toggle-left" style="font-size: 125%; margin:10px;">
    In-Stock Side Bar
  </div>


<!-- Left Slidebar -->
<div class="sb-slidebar sb-left">







  <!-- Lists in Slidebars -->
  <ul class="sb-menu">
    @foreach($items as $item)

      <li>
        @if ($item->available)
        <button style="width: 100%;" class="button-success pure-button mark_item_unavailable" id="{{$item->id}}">
          {{ $item->name}}
        </button>
        @else
          <button style="width: 100%;" class="button-error pure-button mark_item_available" id="{{$item->id}}">
          {{ $item->name }}
          </button>
        @endif
      </li>

    @endforeach
  </ul>
</div>

<!-- ORDERS INSERTED HERE -->
<div class="row">
  <div id="show_orders">
    <ul class="clearing-thumbs" data-clearing>
    </ul>
  </div>
</div>

@stop

@section('additional_static')
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
             <div class="panel" style="margin:10px;" id="<%= order.id %>">
        <% if (order.venmo_id != 0) { %>
          <div style="float:left;">
            <h4 style="color: #3D95CE; font-weight: 200;">Venmo (ID: <%= order.id %>)</h4>
          </div>
        <% } else { %>
          <div style="float:left;">
            <h4 style="font-weight: 200;">Pickup (ID: <%= order.id %>)</h4>
          </div>

        <% }  %>

                <div align="right">
                   <h4>$<%= order.cost %></h4>
                </div>
                <br>
                <div style="float:left;">
                  <h6><%= order.user.name %></h63>
                </div>
                <div align="right">
                  <h6><%= order.time %></h6>
                </div>

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
                    <li><a href="javascript:void(0)" id="<%= order.id %>" class="pure-button pure-button-primary cooked">Cooked</a></li>
                  <% } else { %>
                    <li>Cooked!</li>
                  <% } %>
                  <li><a href="javascript:void(0)" id="<%= order.id %>" class="pure-button pure-button-primary picked">Picked Up</a></li>
                  <% if (!order.refunded && order.venmo_id != 0) { %>
                    <li><a href="javascript:void(0)" id="<%= order.id %>" class="button-error pure-button refund">Refund</a></li>
                  <% } %>
                  <li><a href="javascript:void(0)" id="<%= order.id %>" class="button-error pure-button cancel"
                    style="">Cancel</a></li>
                </ul>
             </div>
          </div>

        </li>

        <%
          }); // end repeat orders
        %>
  </ul>
</script>
@stop

