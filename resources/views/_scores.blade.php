<table class="table table-hover table-bordered table-condensed">
    <thead>
    <tr>
        <th class="align-center" style="background-color: #ccc; width: 30px;">#</th>
        <th style="background-color: #93d7d7;">Team Ranking</th>
        <th style="background-color: #edb825;">versus Team</th>
        <th class="align-center" title="Last scores" style="background-color: #ede553;">Score</th>
        <th class="align-center" style="background-color: #9bed96;">
            <i class="fa-solid fa-thumbs-up green" title="Games Won"></i>
        </th>
        <th class="align-center" style="background-color: #f2cdab;">
            <i class="fa-solid fa-thumbs-down orange" title="Games Lost"></i>
        </th>
        <th class="align-center" style="background-color: #9bed96;">
            <i class="fa-solid fa-square-plus green" title="Wins"></i></th>
        <th class="align-center" style="background-color: #f2cdab;">
            <i class="fa-solid fa-minus-square orange" title="Against"></i>
        </th>
        <th class="align-center" style="background-color: #ccc;">
            <i class="fa-solid fa-percent blue" title="Percentage"></i>
        </th>
        <th class="align-center" style="background-color: #dadada;">
            <i class="fa-solid fa-glass-cheers dark-blue" title="Number of games participated"></i>
        </th>
    </tr>
    </thead>
    <tbody>
    @if (!$scores[0]->get('played'))
        <div class="box-rounded-danger m-5">
            <h3 class="center">No games yet</h3>
        </div>
    @else
        @foreach ($scores as $score)
            <tr>
                <td class="align-center" style="background-color: #eaeaea;" title="Your current position">
                    <strong>{{ $i++ }}</strong>
                </td>
                <td style="background-color: #b9d8d8;">
                    <a href="{{ route('pool.team.show', [$score->get('team')->id]) }}"
                       class="black">{{ $score->get('team')->name }}</a>
                </td>
                <td style="background-color: #e6c466;" title="Last played Team (week {{ $week }})">
                    <a href="{{ route('pool.team.show', [$score->get('played')->id]) }}"
                       class="black">{{ $score->get('played')->name }}</a>
                </td>
                <td class="align-center @if(!is_null($score_id) && $score_id == $score->get('id')) bigger_110 blue bg-light @endif"
                    style="background-color: #f2ed92;">
                    @if ($score->get('last_result') === 'not in')
                        <span class="orange"><i>not in</i></span>
                    @elseif ($score->get('last_result') === 'BYE')
                        <span class="text-muted">BYE</span>
                    @else
                        {{ $score->get('last_result') }}
                    @endif
                </td>
                <td class="align-center" title="Daily games won" style="background-color: #c5f3c2;">
                    {{ $score->get('won') }}
                </td>
                <td class="align-center" title="Daily games lost" style="background-color: #f8e4d1;">
                    {{ $score->get('lost') }}
                </td>
                <td class="align-center" title="Total games won" style="background-color: #c5f3c2;">
                    {{ $score->get('for') }}
                </td>
                <td class="align-center" title="Total games lost" style="background-color: #f8e4d1;">
                    {{ $score->get('against') }}
                </td>
                <td class="align-center text-muted" title="Percentage" style="background-color: #eaeaea;">
                    {{ $score->get('percentage') }}%
                </td>
                <td class="align-center grey" title="{{ $score->get('games_played') }} games participated" style="background-color: #e0e0e0;">
                    {{ $score->get('games_played') }}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
