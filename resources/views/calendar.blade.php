@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>Games schedule <br/><span class="smaller-80 light-grey">Season {{ $cycle }}</span></h3>
        </div>
        <div class="card-body mx-n3">
            @include('pool::_calendar')
        </div>
    </div>

@endsection
