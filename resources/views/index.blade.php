@extends('layouts.master')

@section('content')

<div class="jumbotron">
    <h2>Resin for your Resolver</h2>
    <p>Resin ables data managers to easily generate import files for the PACKED
     Resolver application.</p>

    <ol>
        <li>Upload a 'master' file with all your objects.</li>
        <li>Upload a 'document' file with all the published destination URL's.</li>
        <li>Let Resin merge both files</li>
        <li>Download your usable Import file</li>
    </ol>
</div>

<div class="col-md-8">
        <h3>Resin currently holds</h3>
        <table class="table">
            <tr>
                <td># Objects</td>
                <td>{{ $count_objects }}</td>
            </tr>
            <tr>
                <td># Objects w/o Work PID</td>
                <td>{{ $count_objects_no_work_pid }}</td>
            </tr>

            <tr>
                <td># Objects with Work PID</td>
                <td>{{ $count_objects_has_work_pid }}</td>
            </tr>
            <tr>
                <td># Documents</td>
                <td>{{ $count_documents }}</td>
            </tr>
            <tr>
                <td># Mergable Documents</td>
                <td>{{ $count_mergable_documents }}</td>
            </tr>
            <tr>
                <td># Orphan Documents</td>
                <td>{{ $count_orphan_documents }}</td>
            </tr>
        </table>
    </div>

    <div class="col-md-4">
        <div class="row">
            <h3>Latest imports</h3>
        </div>

        <div class="row documents">
            @if (count($mergers) > 0)
                <table class="table">
                    <tr>
                        <th>Merger ID</th>
                        <th>Created</th>
                        <th>Last downloaded</th>
                    </tr>
                @foreach ($mergers as $merger)
                    <tr>
                        <td>{{ $merger->id}}</td>
                        <td>{{ $merger->created_at}}</td>
                        <td>{{ $merger->downloaded }}</td>
                    </tr>
                @endforeach
                </table>
            @else
                <p>No Mergers yet!</p>
            @endif
        </div>
    </div>

</div>

@endsection
