@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>
                <div class="mb-2">Schedule on the <strong>{{ $date->date->format('jS \o\f M Y') }}</strong></div>
                <div class="smaller-80 light-grey">Season {{ $date->cycle }}</div>
                @if ($date && $date->checkIfGuestHasWritableAccess())
                    <div class="bigger-110 mt-2 dark-grey">Live Scores!</div>
                @endif
            </h3>
        </div>
        <div class="card-body">
            @if (!$date->events()->count())
                <div class="bigger-120 green">There are no games yet</div>
                <br>
            @else
                <table class="table table-bordered table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>Home Team</th>
                        <th>Visitors</th>
                        <th colspan="2" class="align-center">Score</th>
                        <th>Venue</th>
                        @if ($hasAccess)
                            <th class="align-center text-nowrap">Actions</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($date->events as $event)
                        <tr>
                            <td @if($event->score1 > 7)class="green bigger-110" @endif>
                                <a href="{{ route('pool.team.show', $event->team_1->id) }}">{{ $event->team_1->name }}</a>
                            </td>
                            <td @if($event->score2 > 7)class="green bigger-110" @endif>
                                <a href="{{ route('pool.team.show', $event->team_2->id) }}">{{ $event->team_2->name }}</a>
                            </td>
                            @if ($hasAccess || $date->checkIfGuestHasWritableAccess())
                                <td class="align-center">
                                    <div id="form_{{ $event->id }}_team{{ $event->team_1->id }}">
                                        {!! Form::open(['method' => 'PUT', 'route' => ['pool.score.update', $event->id]]) !!}
                                        {!! Form::text('score_'.$event->id, $event->score1, array('id' => 'team' . $event->team_1->id, 'class' => 'score align-center', 'data-team' => $event->team_1->id, 'data-event' => $event->id, 'data-field' => 'score1', 'size' => '2', 'maxlength' => '2', 'title' => "Enter the score")) !!}
                                        {!! Form::close() !!}
                                    </div>
                                    <div id="spinner_{{ $event->id }}_team{{ $event->team_1->id }}" style="display: none;"><span
                                            class="fa-solid fa-arrows-rotate fa-spin fa-fw"></span></div>
                                </td>
                                <td class="align-center">
                                    <div id="form_{{ $event->id }}_team{{ $event->team_2->id }}">
                                        {!! Form::open(['method' => 'PUT', 'route' => ['pool.score.update', $event->id]]) !!}
                                        {!! Form::text('score_'.$event->id, $event->score2, array('id' => 'team' . $event->team_2->id, 'class' => 'score align-center', 'data-team' => $event->team_1->id, 'data-event' => $event->id, 'data-field' => 'score2', 'size' => '2', 'maxlength' => '2',  'title' => "Enter the score")) !!}
                                        {!! Form::close() !!}
                                    </div>
                                    <div id="spinner_{{ $event->id }}_team{{ $event->team_2->id }}" style="display: none;"><span
                                            class="fa-solid fa-arrows-rotate fa-spin fa-fw"></span></div>
                                </td>
                                <td>
                                    <a href="{{ route('pool.venue.show', [$event->venue->id]) }}" class="dark-grey"
                                       title="show the details of {{  $event->venue->name }}">
                                        <i class="fa-solid fa-up-right-from-square smaller-80 light-grey"></i> {{  $event->venue->name }}
                                    </a>
                                </td>
                                @if ($hasAccess)
                                    <td>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <a href="{{ route('pool.event.edit', [$event->id]) }}" title="Edit this event"
                                                   class=""><span class="fa-solid fa-pen-to-square green padding-7px"> </span></a>
                                            </div>
                                            <div class="col-lg-6">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['pool.event.destroy', $event->id], 'onsubmit' => 'javascript:return confirm("Are you sure you want to delete this game?");']) !!}
                                                {!! Form::button('<i class="fa-solid fa-trash-can red bigger-120"></i>', array('type' => 'submit', 'class' => 'btn btn-link', 'title' => "Delete this event")) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            @else
                                <td class="align-center @if($event->score1 > 7)green bigger-110 @endif ">{{ $event->score1 ? $event->score1 : '--' }}</td>
                                <td class="align-center @if($event->score2 > 7)green bigger-110 @endif ">{{ $event->score2 ? $event->score2 : '--' }}</td>
                                <td>
                                    <a href="{{ route('pool.venue.show', [$event->venue->id]) }}" class="grey"
                                       title="show the details of {{  $event->venue->name }}">
                                        <i class="fa-solid fa-up-right-from-square smaller-80 light-grey"></i> {{  $event->venue->name }}
                                    </a>
                                </td>
                            @endif
                        </tr>
                        @if ($event->remark)
                            <tr>
                                <td colspan="5" class="align-center">
                                    <div class="box-rounded-white">{!! nl2br($event->remark) !!}</div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <br>
                @if ($date && $date->checkIfGuestHasWritableAccess())
                    <div class="box-rounded-yellow">
                        <p>
                            <strong>Everybody</strong> has access to update the score from 12h00 to 20h00. Captains should still send the final score by text
                            message. An administrator will check the given scores.
                        </p>
                        <p>
                            After you update a score, click somewhere on the screen. Leaving the input field sends the new score to the server. When it's done,
                            the <span class="green">score color changes to green</span> <span class="green bigger-110">and bigger</span>.
                        </p>
                    </div>
                @endif
            @endif
            @if ($hasAccess)
                <br/>
                <div class="box-rounded-grey">
                    <h3 class="dark-grey"><span class="fa-regular fa-square-plus smaller-80 green"></span> Create a new game</h3>
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            {!! Form($form) !!}
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="box-rounded-lime">
                                <h4>Create a game</h4>
                                <p>
                                    The play date should be automatically selected. Only the <strong>teams</strong> are needed. The <strong>venue</strong>
                                    is automatically selected.
                                </p>
                                <br>
                                <h4>Add the results</h4>
                                <p>The results (scores) will be added later. This is easily done in the <strong>table</strong> above. Try the TAB button for a
                                    change. </p>
                                <p>Fill in the score and select the next field. When the score you entered becomes <span class="green">green</span>, it is saved
                                    in the database.</p>
                                <p>There is no check if the entered results are correct. Just in case there is a no-show or other reasons.</p>
                                <p>From the moment the scores are entered, the scoreboard gets updated.</p>
                                <p><span class="red">If the score is not yet known</span> please enter temporarily the score 0-0.</p>
                                <br>
                                <h4>Remark</h4>
                                <p>You may add a remark about the game entry. Or add it later. This will appear under the individual game. Examples are
                                    'no-show' or 'moved to another venue due to renovations' etc... This will only be shown here, not the overall schedule.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@if (($date && $date->checkIfGuestHasWritableAccess()) || $hasAccess)
    @push('js')
        @if ($date->checkIfGuestHasWritableAccess())

            @include('pool::_pusher', [$score_table = false])
        @endif

        <script src="{{ Storage::disk('static')->url('js/pool-score.js') }}"></script>

        @if($hasAccess)
            <script>
                const venues = {!! $teams !!};
                const home_team = document.getElementById('team1');
                home_team.addEventListener('change', function (e) {
                    const val = e.target.value;
                    document.getElementById('pool_venue_id').value = venues[val];
                })
            </script>
        @endif

    @endpush
@endif
