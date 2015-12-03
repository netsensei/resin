{{-- Merge Modal --}}
<div class="modal fade" id="modal-init-merge">
  <div class="modal-dialog">
    <div class="modal-content">
        {!! Form::open(array('url'=>'/merge','method'=>'POST')) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            ×
          </button>
          <h4 class="modal-title">Merge documents and objects</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="text-center">
                    {!! Form::submit('Start merging', array('class'=>'btn btn-primary')) !!}
                    {!! Form::submit('Cancel', array('class'=>'btn btn-default', 'data-dismiss'=>'modal')) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
    </div>
  </div>
</div>
