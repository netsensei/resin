{{-- Upload Objects Modal --}}
<div class="modal fade" id="modal-upload-objects">
  <div class="modal-dialog">
    <div class="modal-content">
        {!! Form::open(array('url'=>'object/upload','method'=>'POST', 'files'=>true)) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            ×
          </button>
          <h4 class="modal-title">Upload object file</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Objects upload</label>
                {!! Form::file('objects_file', array('class' => 'form-control')) !!}
                <p class="errors">{!!$errors->first('image')!!}</p>
                @if(Session::has('error'))
                    <p class="errors">{!! Session::get('error') !!}</p>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <div id="success"> </div>
            {!! Form::submit('Submit', array('class'=>'btn btn-primary')) !!}
            {!! Form::submit('Cancel', array('class'=>'btn btn-default', 'data-dismiss'=>'modal')) !!}
        </div>
    {!! Form::close() !!}
    </div>
  </div>
</div>
