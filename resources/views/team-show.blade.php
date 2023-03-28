@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>Details of the team <strong>{{ $team->name }}</strong></h3>
        </div>
        <div class="card-body">
            @include('pool::_one-team', ['show_venue_title' => true])
            @include('pool::_team-agenda')
        </div>
    </div>

@endsection
