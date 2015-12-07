@extends('layouts.master')

@section('content')

<div class="row page-title-row">
    <div class="col-md-7">
        <h3 class="pull-left">Uploads  </h3>
    </div>
    <div class="col-md-5 text-right">
        <div class="row">
            <div class="col-xs-12 col-sm-9">
                <p>Last generated on {{ $latest->created_at }} | {!! HTML::link('merge/latest', 'Download') !!}</p>
            </div>
            <div class="col-xs-4 col-sm-3">
                <button type="button" class="btn btn-primary btn-md"
                        data-toggle="modal" data-target="#modal-init-merge">
                  <i class="fa fa-upload"></i> Merge
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <p>Resin will merge {{ $merge_count }} entities.</p>
    </div>
</div>

<div class="entities">
    @if (count($documents) > 0)
        <table class="table" id="merge-table">
            <tr>
                <th>PID</th>
                <th>Entity type</th>
                <th>Title</th>
                <th>URL</th>
                <th>Enabled</th>
                <th>Notes</th>
                <th>Format</th>
                <th>Order</th>
                <th>Reference</th>
            </tr>
        @foreach ($documents as $document)
            <tr>
                <td>{{ $document->object_number}}</td>
                <td>{{ $document->entity_type }}</td>
                <td>{{ $document->object->title }}</td>
                <td>{!! HTML::link($document->url, str_limit($document->url, 55)) !!}</td>
                <td>{{ $document->enabled }}</td>
                <td></td>
                <td>{{ $document->format }}</td>
                <td>{{ $document->representation_order }}</td>
                <td>{{ $document->reference }}</td>
            </tr>
        @endforeach
        </table>

        {!! $documents->render() !!}
    @else
        <p>No documents yet!</p>
    @endif
</div>

@include('merge._modals')

@endsection

@section('scripts')
  <script>
    // Startup code
    $(function() {
      $("#merge-table").DataTable();
    });
  </script>
@stop
