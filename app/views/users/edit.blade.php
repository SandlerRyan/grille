<table class="box">



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

<script>
//function taken from http://www.w3resource.com/javascript/form/phone-no-validation.php
$('#submit').click(function (e){
	var inputtxt = $("#phone").val();
  	var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
  	if(inputtxt=="1")  
        {  
      return true;  
        }  
      else  
        {  
        alert("Please enter a valid, 10-digit phone number!");  
        e.preventDefault();
        return false;  
       }  
    });  
</script>
