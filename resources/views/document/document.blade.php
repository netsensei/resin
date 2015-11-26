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
    {!! Form::open(array('url'=>'document/upload','method'=>'POST', 'files'=>true)) !!}
        <div class="form-group">
            <label>Documents upload</label>
            {!! Form::file('documents_file', array('class' => 'form-control')) !!}
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

<div class="documents">
    @if (count($documents) > 0)
        <table class="table">
            <tr>
                <th>Object number</th>
                <th>URL</th>
                <th>type</th>
            </tr>
        @foreach ($documents as $document)
            <tr>
                <td>{{ $document->object_number}}</td>
                <td>{!! HTML::link($document->url, str_limit($document->url, 140)) !!}</td>
                <td>{{ $document->type }}</td>
            </tr>
        @endforeach
        </table>

        {!! $documents->render() !!}
    @else
        <p>No documents yet!</p>
    @endif
</div>
@endsection
