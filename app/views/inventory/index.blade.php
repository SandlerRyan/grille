

<div class="row">
<h3> Admin Inventory Management </h3>
<br/>

<!-- Main body of Inventory Tracking -->
<div class="row">

    <table>
      <tr>
        <th width="200">Item</th>
        <th width="50">Add</th>
        <th width="50">Quantity</th>
        <th width="50">Remove</th>
        <th width="50">Units</th>
      </tr>
    @foreach($items as $item)
    
    <tr class="{{ $item->id }}">
      <td>
          <b>{{{ $item->name }}}</b> 
          <br/>
          {{{ $item->description}}}
          </td>
          <td>
            <button type="button" class="addItem" id="add-{{ $item->id }}">+</button>
          </td>
          <td>
            <div class="itemQuantity" id="value-{{ $item->id }}">{{ $item->quantity }}</div>
          </td>          
          <td>
            <button type="button" class="removeItem" id="remove-{{ $item->id }}">-</button>
      	  </td>
          <td>
        	 {{{ $item->units}}}
          </td>
        </tr>
      @endforeach
    </table>

</div>

<!-- inventory.js handles all ajax calls to the cart -->
<script type="text/javascript" src="{{ URL::asset('js/inventory.js') }}"></script>
<script>
 
</script>

</div>

</div>
