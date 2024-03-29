@extends('layouts.admin')

@section('content')
<div class="row">
  <h3> Admin Inventory Management </h3>
  <br/>
</div>


<!-- Main body of Inventory Tracking -->
<div class="row">
    <table class="pure-table pure-table-horizontal">
      <thead>
        <tr>
          <th width="200">Item</th>
          <th width="50">Add</th>
          <th width="20">Q</th>
          <th width="50">Remove</th>
          <th width="50">Units</th>
        </tr>
      <thead>
      <tbody>
      @foreach($items as $item)

      <tr class="{{ $item->id }}">
        <td>
            <b>{{{ $item->name }}}</b>
            <br/>
            {{{ $item->description}}}
            </td>
            <td>
              <button class="pure-button pure-button-primary addItem" id="add-{{ $item->id }}">+</button>
            </td>
            <td>
              <div class="itemQuantity" id="value-{{ $item->id }}">{{ $item->quantity }}</div>
            </td>
            <td>
              <button class="pure-button pure-button-primary removeItem" id="remove-{{ $item->id }}">-</button>
        	  </td>
            <td>
          	 {{{ $item->units}}}
            </td>
          </tr>
        @endforeach
        </tbody>
    </table>
</div>
@stop

@section('additional_static')
<!-- inventory.js handles all ajax calls to the cart -->
<script type="text/javascript" src="{{ URL::asset('js/inventory.js') }}"></script>
@stop