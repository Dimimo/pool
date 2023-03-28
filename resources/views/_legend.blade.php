<div class="mb-4">
    <div class="align-center">
        <button class="btn btn-yellow dark-grey" type="button" data-toggle="collapse" data-target="#legend" aria-expanded="false" aria-controls="legend">
            <i class="fa-solid fa-hand-point-right orange bigger-120"></i>
            Show/hide the legend and remarks of the score sheet
        </button>
    </div>

    <div class="collapse mt-4" id="legend">
        <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4>Legend</h4>
                    </div>
                    <div class="card-body bg-white">
                        <div class="row mb-2">
                            <div class="col-1">
                                <i class="fa-solid fa-thumbs-up green float-right" title="Games Won"></i>
                            </div>
                            <div class="col-11">The number of daily games won (8 or higher is a win)</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-1">
                                <i class="fa-solid fa-thumbs-down orange float-right" title="Games Lost"></i>
                            </div>
                            <div class="col-11">The number of daily games lost (7 or lower)</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-1">
                                <i class="fa-solid fa-square-plus green float-right" title="Wins"></i>
                            </div>
                            <div class="col-11">The number of individual games won, including doubles</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-1">
                                <i class="fa-solid fa-minus-square orange float-right" title="Loses"></i>
                            </div>
                            <div class="col-11">The number of individual games lost</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-1">
                                <i class="fa-solid fa-percent blue float-right" title="Points"></i>
                            </div>
                            <div class="col-11">Percentage based on team effort and individual outcome</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-1">
                                <i class="fa-solid fa-champagne-glasses dark-blue float-right" title="Number of games participated"></i>
                            </div>
                            <div class="col-11">
                                The number of games the team has participated in. Future games, (semi-)finals and BYE's influences that number
                            </div>
                        </div>
                        <div class="box-rounded-grey mt-2">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Some remarks:</h5>
                                    <p>
                                        Each team is shown once in the ranking. The score of the latest game is shown <strong>twice</strong>. It could show in
                                        <i>reverse</i>
                                        as it ignores home or away status. If in doubt, <a href="{{ route('pool.calendar') }}">check the day scores</a>.
                                    </p>
                                    <p>
                                        The ranking is determined by (1) alphabetical order, (2) your daily wins, (3) the amount of individual games
                                        <strong>won</strong> <i>vs</i> (4) the <strong>lost</strong> individual games. Lost daily games are irrelevant in the
                                        makeup
                                        of
                                        the ranking.
                                    </p>
                                    <p>
                                        <span class="fa-solid fa-percent blue"></span> is calculated as following. (where TG = total
                                        games, including semi and finals)<br>
                                        <span class="text-monospace">
                                    (((Games Won / TG) x 100) + (Individual Games Won / (TG x 15) x 100) / 2)</span>
                                    </p>
                                    <p>
                                        Teams that didn't make it to the finals are negatively influenced by the percentage.
                                        This is to avoid that the nr 3 can have a higher percentage than the runner up.
                                    </p>
                                    <p>
                                        Team and individual wins influence the score. To get a 100% you should win every game at
                                        the maximum score of 15/0.
                                    </p>
                                    <p>
                                        If 2 teams end up with the same scores (daily + individual), the ranking will be alphabetic. The calculation does
                                        <strong>not</strong> take mutual game results into account. If this is the case, please refer to our
                                        <a href="https://www.facebook.com/groups/pgpoolleague" target="_blank">FaceBook group</a>.
                                    </p>
                                    <p>
                                        <strong>The winner and the party venue</strong> shows as the winner team <i>vs</i> itself. No scores will be provided.
                                    </p>
                                    <p>
                                        <strong>Have fun!</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
