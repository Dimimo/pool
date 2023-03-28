<div class="box-rounded-white row">
    @if (isset($show_venue_title))
        <div class="col-12 align-center bigger-140">{{ $team->venue->name }}</div>
    @endif
    <div class="col-12 align-center bigger-120">{{ $team->venue->address }}</div>
    <div class="col-12 align-center bigger-120">
        <i class="fa-solid fa-user-circle green" title="contact person"></i> {{ $team->venue->contact_name }}
    </div>
    <div class="col-12 align-center bigger-120">
        <i class="fa-solid fa-mobile-alt green"></i> {{ $team->venue->contact_nr }}
    </div>
</div>
<br/>
@if (!$team->players()->count())
    <h4>There are no players yet.
        @if ($hasAccess)
            Please <a href="{{ route('pool.players.edit', [$team->id]) }}">create one</a>
        @endif
    </h4>
@else
    @include('pool::_players')
@endif
