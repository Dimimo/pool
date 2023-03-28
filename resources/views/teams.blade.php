@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>Overview of the participating teams <br/><span class="smaller-80 light-grey">Season {{ $cycle }}</span></h3>
        </div>
        <div class="card-body">
            @include('pool::_teams')
        </div>
    </div>

@endsection
