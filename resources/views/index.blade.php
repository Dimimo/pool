@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>
                Competition results week {{ $week }}
            </h3>
            <p class="light-grey mt-2 bigger-130">Season <strong>{{ $cycle }}</strong></p>
            @if ($date && $date->checkIfGuestHasWritableAccess())
                <p class="mt-3">
                    <a href="{{ route('pool.date.show', [$date->id]) }}" class="bigger-150 white" title="Live scores">Live Scores</a>
                </p>
                <p>
                    <a href="{{ route('pool.date.show', [$date->id]) }}" title="The current day schedule" class="white bigger-110">
                        <span class="fa-regular fa-circle-right"></span> Update your score here <span class="fa-regular fa-circle-left"></span>
                    </a>
                </p>
            @endif
        </div>
        <div class="card-body">
            <div id="announcement_title">
                @include('pool::announcements.title')
            </div>

            <div id="score_table">
                @include('pool::_scores')
            </div>

            <div id="legend">
                @include('pool::_legend')
            </div>

            <div id="announcement_body">
                @include('pool::announcements.body')
            </div>

            <div id="chart">
                @if ($chart)
                    @include('pool::_charts')
                @endif
            </div>

        </div>
    </div>

@endsection

@if ($date && $date->checkIfGuestHasWritableAccess())
    @push('js')

        @include('pool::_pusher', [$score_table = true])
    @endpush
@endif
