@extends('layouts.admin')

@section('content')
<div class="textblasts">
        <textarea id="textareablast"></textarea>
        <button id="send_text_blast">Send Text Blast</button>

</div>
@stop

@section('additional_static')
<script type="text/js">

$(document).on('click', '#send_text_blast', function() {
  console.log($("#textareablast").val())

  var message = $("#textareablast").val();
  $.ajax({
    type: "POST",
    url: "/dashboard/send_text_blast/" + message,
    success: function(data){
      console.log(data)
    },
    error: function() {
      alert('Sorry, something bad happened');
    }
  });
});

</script>