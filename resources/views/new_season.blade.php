@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>Create the teams for a new season
                <br/><span class="smaller-80 light-grey">Season {{ $date->cycle }}</span>
            </h3>
        </div>
        <div class="card-body">
            <div class="box-rounded-info">
                <h4 class="text-center red">You only see this page once!</h4>
                <p>
                    Here you can easily select the teams participating in the new season. A list of the last 20 teams of previous seasons are
                    selected. Remember you can change any team's name later on in the Teams Overview page.
                </p>
                <p>
                    You can create up to 5 new teams. <strong>Have you created a possible new venue?</strong> If not, don't worry, choose any venue,
                    add a new venue later and change its venue in the Team Overview page.
                </p>
                <p>
                    If a BYE is needed, check the box.
                </p>
            </div>
            <div class="m-3">
                {!! Form::open(['method' => 'POST', 'route' => ['pool.new_season.create']]) !!}
                <div class="mb-3">
                    {!! Form::hidden('cycle', $date->cycle) !!}
                    {!! Form::hidden('date', $date->id) !!}
                    {!! Form::button('<i class="fa-regular fa-square-plus"></i> Add these teams', array('type' => 'submit', 'class' => 'btn btn-success btn-block dark')) !!}
                </div>

                <div class="box-rounded-yellow my-2">
                    {!! Form::checkbox('bye', '1', null, ['id' => 'bye', 'class' => 'ml-3']) !!} <label for="bye">Does the season {{ $date->cycle}} need a
                        BYE?</label>
                </div>

                <div>
                    <ul class="list-group">
                        @foreach($teams as $team)
                            <li class="list-group-item d-flex justify-content-between align-items-center form-check">
                                <div class="">
                                    {{ $team->cycle }}
                                </div>
                                <div class="">
                                    <label class="form-check-label" for="{{ 'team['. $team->id .']' }}">
                                        <strong>{{ $team->name }}</strong> ({{ $team->venue->name }})
                                        @if ($team->players()->count())
                                            - Captain: <strong>{{ $team->players()->first()->name }}</strong>
                                        @endif
                                    </label>
                                </div>
                                <div class="">
                                    {!! Form::checkbox('team['. $team->id .']', 1, null, ['id' => 'team['. $team->id .']', 'class' => 'align-middle']) !!}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @for($i=0;$i<5;$i++)
                    <div class="box-rounded-white my-2">
                        <label for="name[{{ $i }}]">Team name</label>
                        {!! Form::text("name[$i]") !!}
                        <label for="pool_venue_id[$i]">Venue</label>
                        {!! Form::select("pool_venue_id[$i]", $venues, null) !!}
                    </div>
                @endfor

                <div class="mt-3">
                    {!! Form::button('<i class="fa-regular fa-square-plus"></i> Add these teams', array('type' => 'submit', 'class' => 'btn btn-success btn-block dark')) !!}
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@include('pool::common.datepicker')
