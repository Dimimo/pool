@extends('pool::layouts.pool')

@section('content')

    <div class="card">
        <div class="card-header text-white align-center">
            <h3>All Pool Seasons</h3>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="thead-light">
                <tr>
                    <th>Season</th>
                    <th>Started at</th>
                    <th>Playing day</th>
                    <th>Games played <span class="text-muted smaller-80 align-top">*</span></th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $c => $val)
                    <tr>
                        <td>
                            <a href="{{ route('pool.cycle', [$c]) }}">
                                <strong>{{ $c }}</strong>
                            </a>
                        </td>
                        <td>
                            <strong>{{ $val['season'] }}</strong>
                        </td>
                        <td>
                            {{ $val['league'] }}
                        </td>
                        <td>
                            {{ trans_choice('plural.games', $val['count'], ['value' => $val['count']]) }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4 text-muted">* total number of games includes BYE's, excludes final party</div>
        </div>
    </div>

@endsection
