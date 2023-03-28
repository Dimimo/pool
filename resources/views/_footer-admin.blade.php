@if ($hasAccess)
    <div class="box-rounded-orange mt-4">
        <div class="box-top mb-1">
            <h5 class="text-center">For Admins only</h5>
        </div>
        <div class="mb-1 mt-3 bigger-110">Season dependent</div>
        <div class="mb-1">
            <a href="{{ route('pool.date.create') }}">Add a playing date</a>, also the starting point for a <strong>new season</strong>.<br/>
        </div>
        <div class="mb-3">
            <a href="{{ route('pool.team.create') }}">Add a Team</a> or copy previous teams when creating a new season<br>
            <i class="smaller-90">(remember, names can be changed later on, venues and captains are copied too).</i>
        </div>
        <div class="mb-1">
            <a href="{{ route('pool.player.create') }}">Add a Player</a>,
            usually a captain, can be done at the <a href="{{ route('pool.teams') }}">Team Overview</a> page.
        </div>

        <div class="mt-3 mb-1 bigger-110">Season independent</div>
        <a href="{{ route('pool.venue.create') }}">A new Venue</a> can be added any time. Do this <strong>before creating a new season</strong>, if applicable.

        <div class="mt-3 mb-1 bigger-110">Admin actions for a running season</div>
        In case of f.ex. a typhoon, we can <a href="{{ route('pool.dates.edit') }}">shift the playing dates</a> for the current season.<br>
        Here we can delete dates without games, we can even delete a season. If it has games,
        <a href="{{ route('pool.calendar') }}">delete these games first</a>.
    </div>
@endif
