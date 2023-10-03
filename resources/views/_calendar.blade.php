<div class="row">
    @foreach ($dates as $date)
        @if ($date && $date->events && $date->events()->count() > 0)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-header align-center {{ $date->regular ? 'bg-success' : 'bg-info' }}">
                    <a href="{{ route('pool.date.show', [$date->events()->first()->pool_date_id]) }}" class="text-white bigger-130" title="click for details">
                        {{ $date->date->format('jS \o\f M Y') }}
                    </a>
                    @if ($date->title)
                        <div class="text-white bigger-120">{{ $date->title }}</div>
                    @endif
                    @if ($date->checkIfGuestHasWritableAccess())
                        <div class="text-white bigger-130" title="click to edit your score">
                            <img class="ml-2 mb-1" src="https://static.puertoparrot.com/img/right-arrow.svg" alt="" width="24">
                            Live scores!
                            <img class="mr-2 mb-1" src="https://static.puertoparrot.com/img/left-arrow.svg" alt="" width="24">
                        </div>
                    @endif
                </div>
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr class="bg-light">
                        <th class="align-left red">Home Team</th>
                        <th class="align-right blue">Visitors</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($date->events as $event)
                        @if ($event->team_1->venue == $event->venue)
                            <tr>
                                <td class="align-left">
                                    <a href="{{ route('pool.team.show', [$event->team_1->id]) }}"
                                       class="dark-grey">{{ $event->team_1->name }}</a>{!! $event->score1 !== null &&  $event->team_2->name !== 'BYE' ? ' <span class="float-right ' . ($event->score1>7 ? 'green' : 'red') . '">'.$event->score1.'</span>' : '' !!}
                                </td>
                                <td class="align-right">
                                    <a href="{{ route('pool.team.show', [$event->team_2->id]) }}"
                                       class="dark-grey">{{ $event->team_2->name }}</a>
                                    {!! $event->score2 !== null &&  $event->team_2->name !== 'BYE' ? ' <span class="float-left ' . ($event->score2>7 ? 'green' : 'red') . '">'.$event->score2.'</span>' : '' !!}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td class="align-left">
                                    <a href="{{ route('pool.team.show', [$event->team_1->id]) }}"
                                       class="dark-grey">{{ $event->team_1->name }}</a>
                                    {!! $event->score1 !== null ? ' <span class="float-right ' . ($event->score1>7 ? 'green' : 'red') . '">'.$event->score1.'</span>' : '' !!}
                                </td>
                                <td class="align-right">
                                    <a href="{{ route('pool.team.show', [$event->team_2->id]) }}"
                                       class="dark-grey">{{ $event->team_2->name }}</a>{!! $event->score2 !== null ?  ' <span class="float-left ' . ($event->score2>7 ? 'green' : 'red') . '">'.$event->score2.'</span>' : '' !!}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="red align-center">
                                    <i class="fa-solid fa-circle-right"></i> Game @ {{ $event->venue->name }} <i class="fa-solid fa-circle-left"></i>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card-header align-center {{ $date->regular ? 'bg-success' : 'bg-info' }}">
                    <a href="{{ route('pool.date.show', [$date->id]) }}" class="text-white bigger-130" title="click for details">
                        {{ $date->date->format('jS \o\f M Y') }}
                    </a>
                    @if ($date->title)
                        <span class="mt-2 {{ $date->regular ? 'yellow' : 'light-grey' }}">{{ $date->title }}</span>
                    @endif
                </div>
                @if ($hasAccess)
                    <div class="box-rounded-orange m-2">
                        There are no games yet, <a href="{{ route('pool.date.show', [$date->id]) }}">please create some</a> or <a
                            href="{{ route('pool.dates.edit') }}">delete the date if this is an error</a>. Only admins can see this.
                    </div>
                @else
                    <div class="box-rounded-lime m-2">
                        There are no games yet. This is a placeholder. The teams will appear when the calendar is created.
                    </div>
                @endif
            </div>
        @endif
    @endforeach
</div>
