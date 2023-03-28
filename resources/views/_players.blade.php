<div class="box-rounded-grey">
    <h3 class="align-center">Players</h3>
    @foreach ($team->players as $player)
        <div class="row">
            <div class="col-5 align-right bigger-120">{{ $player->name }}</div>
            <div class="col-1 align-center">
                @if ($player->captain)
                    <i class="fa-solid fa-user-tie orange"></i>
                @else
                    <i class="fa-solid fa-user green"></i>
                @endif
            </div>
            <div class="col-6 text-nowrap float-right">{{ $player->contact_nr }}</div>
        </div>
    @endforeach

    @if ($hasAccess)
        <br/>
        <div class="bigger-110 align-right"><a href="{{ route('pool.players.edit', [$team->id]) }}"><i class="fa-solid fa-pen-to-square"></i> Edit the team
                players</a></div>
    @endif
</div>

