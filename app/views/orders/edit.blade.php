<div class="row">

    <div class="col-xs-8">
        <h3>Edit Field</h3>
        <hr/>
        <form role="form" method="post" action="/fields/{{{ $field->id }}}">
        <div class="form-group">
            <label>Field Title</label>
            <input type="text" name="name" class="form-control" value="{{{ $field->name }}}" />
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
  </div>
</div>
