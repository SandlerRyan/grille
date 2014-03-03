<table class="box">
<div>
@if($failure)
    <h5><font color="red">{{$failure}}</font></h5>
@endif
</div>

{{ Form::model($user, array('url' => array('/edit_user/' . $user->id), 'method' => 'GET')) }}
	<p>	{{ Form::label('preferred_name', 'Preferred Name') }}
		{{ Form::text('preferred_name') }} </p>
	<p> {{ Form::label('phone_number', 'Phone Number') }}
		{{ Form::text('phone_number', '', array('id' => 'phone')) }} </p>

	<p> {{ Form::label('hours_notification', 'Update me about special hours') }}
		{{ Form::checkbox('hours_notification')}}</p>
	<p> {{ Form::label('deals_notification', 'Update me about deals and discounts') }}
		{{Form::checkbox('deals_notification')}}</p>
	<p>{{ Form::submit('Submit', array('id' => 'submit')) }}</p>
{{ Form::close() }}

</table>

