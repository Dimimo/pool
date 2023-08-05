{{--<script src="{{ Storage::disk('static')->url('js/pool.js') }}"></script>--}}
<script src="{{ asset('js/pool.js') }}"></script>
<script>
    //CHANGE THIS TO ONLY ISSUE ECHO WHEN THE TIME WINDOW IS OPEN, IF NOT, AN ADMIN WILL TRIGGER PUSHER AS WELL AND THAT IS NOT NEEDED
    Pusher.logToConsole = false;
    Echo.channel('pool-score')
        .listen('.score-event', (e) => {
            @if ($score_table)
            //index score table overview actions
            const _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{ route('pool.table.update') }}",
                cache: false,
                data: {
                    "score_id": e.score.id,
                    _token
                },
                success: function (html) {
                    $('div#score_table').fadeOut('slow', 'linear', function () {
                        $(this).html(html);
                    }).fadeIn('slow', 'linear');
                }
            });
            @else
            //daily results actions
            let event1 = $("input#team" + e.score.team1);
            event1.val(e.score.score1);
            let event2 = $("input#team" + e.score.team2);
            event2.val(e.score.score2).css('box-shadow:0 0 20px blue;');
            @endif
            //snackbar('Your score has been updated', 'success');
        });
    //END PUSHER
</script>
