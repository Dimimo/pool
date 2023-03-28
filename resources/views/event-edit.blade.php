@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>Edit the event <strong>{{ $event->team_1->name }}</strong> - <strong>{{ $event->team_2->name }}</strong> on {{ $event->date->date }}</h3>
        </div>
        <div class="card-body">
            {!! Form($form) !!}
        </div>
    </div>

@endsection
