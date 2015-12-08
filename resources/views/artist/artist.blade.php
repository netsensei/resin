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
    <h3 class="pull-left">Artists</h3>
  </div>
  <div class="col-md-6 text-right">
    <button type="button" class="btn btn-primary btn-md"
            data-toggle="modal" data-target="#modal-upload-artists">
      <i class="fa fa-upload"></i> Upload artists
    </button>
  </div>
</div>

<div class="row col-md-12">
</div>

<hr />

<div class="artists">
    @if (count($artists) > 0)
        <table class="table">
            <tr>
                <th>Artist name</th>
                <th>Date of birth</th>
                <th>Date of death</th>
                <th>PID</th>
            </tr>
        @foreach ($artists as $artist)
            <tr>
                <td>{{ $artist->name}}</td>
                <td>{{ $artist->date_birth }}</td>
                <td>{{ $artist->date_death }}</td>
                <td>{{ $artist->PID }}</td>
            </tr>
        @endforeach
        </table>

        {!! $artists->render() !!}
    @else
        <p>No artists yet!</p>
    @endif
</div>
@endsection
