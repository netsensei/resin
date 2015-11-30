@extends('layouts.master')

@section('content')
<div class="messages">
        @if(Session::has('success'))
          <div class="alert alert-success" role="alert">
          {!! Session::get('success') !!}
          </div>
        @endif
</div>

<div class="upload-form">
    {!! Form::open(array('url'=>'object/upload','method'=>'POST', 'files'=>true)) !!}
        <div class="form-group">
            <label>Objects upload</label>
            {!! Form::file('objects_file', array('class' => 'form-control')) !!}
            <p class="errors">{!!$errors->first('image')!!}</p>
            @if(Session::has('error'))
                <p class="errors">{!! Session::get('error') !!}</p>
            @endif
        </div>
        <div id="success"> </div>
        {!! Form::submit('Submit', array('class'=>'btn btn-default')) !!}
    {!! Form::close() !!}
</div>

<hr />

<div class="objects">
    @if (count($objects) > 0)
        <table class="table">
            <tr>
                <th>Object number</th>
                <th>Title</th>
                <th>Work PID</th>
            </tr>
        @foreach ($objects as $object)
            <tr>
                <td>{{ $object->object_number}}</td>
                <td>{{ $object->title }}</td>
                <td>{!! HTML::link($object->work_pid, $object->work_pid) !!}</td>
            </tr>
        @endforeach
        </table>

        {!! $objects->render() !!}
    @else
        <p>No objects yet!</p>
    @endif
</div>
@endsection
