@extends('layouts.master')

@section('content')

<div class="mergecount">
 <p>Resin will merge {{ $merge_count }} entities.</p>
</div>

<div class="entities">
    @if (count($documents) > 0)
        <table class="table">
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


@endsection
