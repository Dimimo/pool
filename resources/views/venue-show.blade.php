@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>Details of <strong>{{ $venue->name }}</strong></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 align-center bigger-120">{{ $venue->address }}</div>
                <div class="col-12 align-center bigger-120"><i class="fa-solid fa-user-circle"></i> {{ $venue->contact_name }}</div>
                <div class="col-12 align-center bigger-120"><i class="fa-solid fa-mobile-screen-button"></i> {{ $venue->contact_nr }}</div>
            </div>
            <br/>
            @if (!$venue->teams()->count())
                <h4>There are no teams yet, please <a href="{{ route('pool.team.create', [$venue->id]) }}">create one</a>.</h4>
            @else
                <div class="row">
                    @foreach ($venue->teams as $team)
                        @if ($team->cycle == $cycle)
                            <div class="box-rounded-white col-{!! $venue->teams()->count() > 1 ? '6' : '12' !!}">
                                <div class="bigger-150 align-center"><a href="{{ route('pool.team.show', [$team->id]) }}">{{ $team->name }}</a></div>
                                <br/>
                                @include('pool::_players')
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection
