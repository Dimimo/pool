<h3>Participating teams</h3>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Teams</th>
        <th>Venue</th>
        <th><i class="fa-solid fa-list-ol" title="Number of Players"></i></th>
        <th>Captain</th>
        <th>Contact</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($teams as $team)
        <tr>
            <td>
                <div class="row">
                    @if ($hasAccess)
                        <div class="col-1">
                            <a href="{{ route('pool.team.edit', [$team->id]) }}"><i class="fa-solid fa-pen-to-square green smaller-80"
                                                                                    title="Edit the Team"></i></a>
                        </div>
                        <div class="col-1 mr-2">
                            {!! Form::open(['method' => 'DELETE', 'route' => ['pool.team.delete', $team->id], 'onsubmit' => 'javascript:return confirm("Are you sure you want to delete this team?");']) !!}
                            {!! Form::button('<i class="fa-solid fa-trash-can red"></i>', array('type' => 'submit', 'class' => 'btn btn-link', 'title' => "Delete this team")) !!}
                            {!! Form::close() !!}
                        </div>
                    @endif
                    <div class="col">
                        <a href="{{ route('pool.team.show', [$team->id]) }}">{{ $team->name }}</a>
                    </div>
                </div>
            </td>
            <td>
                @if ($hasAccess)
                    <a href="{{ route('pool.venue.edit', [$team->venue->id]) }}"><i class="fa-solid fa-pen-to-square green smaller-80"
                                                                                    title="Edit the Venue"></i></a>
                @endif
                <a href="{{ route('pool.venue.show', [$team->venue->id]) }}">{{ $team->venue ? $team->venue->name : '(unknown)' }}</a>
            </td>
            <td>{{ $team->players()->count() }}</td>
            <td>
                @if ($hasAccess)
                    <a href="{{ route('pool.players.edit', [$team->id]) }}"><i class="fa-solid fa-pen-to-square green smaller-80"
                                                                               title="Edit the players/captain"></i></a>
                @endif
                {{ $team->captain() ? $team->captain()->name : '(unknown)' }}
            </td>
            <td>{{ ($team->captain() && $team->captain()->contact_nr) ? $team->captain()->contact_nr : @$team->venue->contact_nr }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
