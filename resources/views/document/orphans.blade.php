@extends('layouts.master')

@section('content')
<h2>Orphan documents</h2>

<p>Orphan documents are URL's that cannot be matched with any object through
    their object number either due to an error in the number or because the
    expected object simply is not registered in the database.</p>

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
@endsection
