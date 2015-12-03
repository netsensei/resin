@extends('layouts.master')

@section('content')

<div class="row page-title-row">
  <div class="col-md-6">
    <h3 class="pull-left">Objects</h3>
  </div>
  <div class="col-md-6 text-right">
    <button type="button" class="btn btn-primary btn-md"
            data-toggle="modal" data-target="#modal-upload-objects">
      <i class="fa fa-upload"></i> Upload objects
    </button>
  </div>
</div>

<div class="messages">
        @if(Session::has('success'))
          <div class="alert alert-success" role="alert">
          {!! Session::get('success') !!}
          </div>
        @endif
</div>

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

@include('object._modals')

@stop
