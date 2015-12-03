@extends('layouts.master')

@section('content')
<div class="messages">
        @if(Session::has('success'))
          <div class="alert alert-success" role="alert">
          {!! Session::get('success') !!}
          </div>
        @endif
</div>

<div class="row page-title-row">
  <div class="col-md-6">
    <h3 class="pull-left">Documents</h3>
  </div>
  <div class="col-md-6 text-right">
    <button type="button" class="btn btn-primary btn-md"
            data-toggle="modal" data-target="#modal-upload-documents">
      <i class="fa fa-upload"></i> Upload documents
    </button>
  </div>
</div>

<div class="row col-md-12">
    <p>A document is a published resource. This can be a HTML, JSON or XML document
    or an image file. Documents can be related to objects through their associated
    object number. The overview below displays all registered documents.</p>
</div>

<hr />

<div class="documents">
    @if (count($documents) > 0)
        <table class="table">
            <tr>
                <th>Object number</th>
                <th>URL</th>
                <th>type</th>
                <th>order</th>
            </tr>
        @foreach ($documents as $document)
            <tr>
                <td>{{ $document->object_number}}</td>
                <td>{!! HTML::link($document->url, str_limit($document->url, 100)) !!}</td>
                <td>{{ $document->type }}</td>
                <td>{{ $document->order }}</td>
            </tr>
        @endforeach
        </table>

        {!! $documents->render() !!}
    @else
        <p>No documents yet!</p>
    @endif
</div>

@include('document._modals')

@stop

