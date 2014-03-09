<div>
@if($failure)
    <h5><font color="red">{{$failure}}</font></h5>
@endif
</div>


<div class="row">
  <div class="large-12 columns">
      <div class="panel" id="order.id">


<table>
{{ Form::model($user, array('url' => array('/user/edit_user/' . $user->id), 'method' => 'GET')) }}
	<div class="row collapse">
		<div class="large-4 columns">
			{{ Form::label('preferred_name', 'Preferred Name') }}
			{{ Form::text('preferred_name') }}
		</div>
	</div>
	<div class="row collapse">
		<div class="large-4 columns">
			{{ Form::label('phone_number', 'Phone Number') }}
			{{ Form::text('phone_number', '', array('placeholder'=>"(XXX) XXX-XXXX", 'required')) }}
		</div>
	</div>

<!-- 	<input id="checkbox1" type="checkbox"><label for="checkbox1">Update me about special hours</label>
	<br/>
    <input id="checkbox2" type="checkbox"><label for="checkbox2">Update me about deals and discounts</label> -->



    		{{ Form::checkbox('hours_notification', '', array('type'=>'checkbox', 'id'=>'checkbox1'))}}
			{{ Form::label('hours_notification_label', 'Update me about special hours',
									array('for'=>'checkbox1')) }}

			<br/>
			{{Form::checkbox('deals_notification', '', array('type'=>'checkbox','id'=>'checkbox2'))}}
			{{ Form::label('deals_notification_label', 'Update me about deals and discounts',
										array('for'=>'checkbox2')) }}




	<div class="row">
	{{ Form::submit('Submit', array('id' => 'submit', 'class' => 'radius button')) }}
	</div>

{{ Form::close() }}
</table>


</div>
</div>

