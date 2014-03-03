
<div>
@if($failure)
    <h5><font color="red">{{$failure}}</font></h5>
@endif
</div>

<table>
{{ Form::model($user, array('url' => array('/edit_user/' . $user->id), 'method' => 'GET')) }}
	<div class="row collapse">
		<div class="large-4 columns">
			{{ Form::label('preferred_name', 'Preferred Name') }}
			{{ Form::text('preferred_name') }} 
		</div>
	</div>
	<div class="row collapse">
		<div class="large-4 columns">
			{{ Form::label('phone_number', 'Phone Number') }}
			{{ Form::text('phone_number', '', array('placeholder'=>"(XXX) XXX-XXXX")) }} 
		</div>
	</div>
	<div class="row collapse">
		<div class="large-6 columns">
			{{ Form::label('hours_notification', 'Update me about special hours',
									array('for'=>'check1', 'class'=>"left inline")) }}
				{{ Form::checkbox('hours_notification', '', array('type'=>'checkbox','id'=>'check1'))}}
		</div>
	</div>
	<div class="row collapse">
		<div class="large-6 columns">
			{{ Form::label('deals_notification', 'Update me about deals and discounts', 
										array('for'=>'check2', 'class'=>"left inline")) }}
			{{Form::checkbox('deals_notification', '', array('type'=>'checkbox','id'=>'check2'))}}
		</div>

	</div>
	<div class="row">
	{{ Form::submit('Submit', array('id' => 'submit', 'class' => 'radius button')) }}
	</div>
{{ Form::close() }}
</table>





