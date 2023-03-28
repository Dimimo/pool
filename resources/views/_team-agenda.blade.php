<br/>
<div class="box-rounded-white">
    <h3 class="align-center">The playing schedule of {{ $team->name }}</h3>
    <table class="table table-hover table-striped table-bordered">
        <thead>
        <tr>
            <th><strong>Date</strong></th>
            <th class="align-left red">Home Team</th>
            <th class="align-left blue">Visitor</th>
            <th class="align-center">Score</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($dates as $date)
            @foreach ($date->events as $event)
                @if ($team->id === $event->team_1->id)
                    <tr>
                        <td>
                            <a href="{{ route('pool.day.schedule', $event) }}" title="download this personalized day schedule"><i
                                    class="fa-regular fa-file-pdf green"></i></a>
                            <a href="{{ route('pool.date.show', [$date->id]) }}">{{ $event->date->date->format('jS \o\f M Y') }}</a>
                        </td>
                        <td class="green"><strong>{{ @$team->name }}</strong></td>
                        <td><a href="{{ route('pool.team.show', [$event->team_2->id]) }}">{{ $event->team_2->name }}</a></td>
                        <td class="align-center">
                            @if($event->team_2->name === 'BYE')
                                <span class="green">BYE</span>
                            @elseif ($event->score1 !== null)
                                <strong class="{{ $event->score1 > 7 ? 'green' : 'red' }}">{{ $event->score1 }}</strong>/{{ $event->score2 }}
                            @elseif($event->score1 === 0 && $event->score2 === 0)
                                <span class="red">Not in</span>
                            @else
                                ----
                            @endif
                        </td>
                    </tr>
                @elseif($team->id === $event->team_2->id)
                    <tr>
                        <td>
                            <a href="{{ route('pool.day.schedule', $event) }}" title="download this personalized day schedule"><i
                                    class="fa-regular fa-file-pdf green"></i></a>
                            <a href="{{ route('pool.date.show', [$date->id]) }}">{{ $event->date->date->format('jS \o\f M Y') }}</a>
                        </td>
                        <td><a href="{{ route('pool.team.show', [$event->team_1->id]) }}">{{ $event->team_1->name }}</a></td>
                        <td class="green"><strong>{{ @$team->name }}</strong></td>
                        <td class="align-center">
                            @if($event->team_2->name === 'BYE')
                                <span class="green">BYE</span>
                            @elseif ($event->score2 !== null)
                                {{ $event->score1 }}/<strong class="{{ $event->score2 > 7 ? 'green' : 'red' }}">{{ $event->score2 }}</strong>
                            @elseif($event->score1 === 0 && $event->score2 === 0)
                                <span class="red">Not in</span>
                            @else
                                ----
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
        </tbody>
    </table>
</div>
