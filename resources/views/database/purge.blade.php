@extends('layouts.master')

@section('content')

<div class="messages">
        @if(Session::has('success'))
          <div class="alert alert-success" role="alert">
          {!! Session::get('success') !!}
          </div>
        @endif
</div>

<div class="form center-block" style="width:400px">
    <h2>Purge the database</h2>

    <p>Pressing the button below will purge the database, you will not get a
        confirmation box, so be sure before you do this!</p>

    {!! Form::open(array('url'=>'settings/purge','method'=>'POST')) !!}
        <div id="success"> </div>
        {!! Form::submit('Purge database', array('class'=>'btn btn-danger btn-large btn-block')) !!}
    {!! Form::close() !!}
</div>

@endsection
