@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>Create a Venue</h3>
        </div>
        <div class="card-body">
            {!! Form($form) !!}
        </div>
    </div>

@endsection
