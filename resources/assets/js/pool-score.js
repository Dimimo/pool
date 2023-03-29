/*
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

//update the chart
const charts = document.getElementsByClassName('chart-update-request');
//check if charts have values, if not, skip the rest, this is only for admins
if (charts.length > 0) {
    const spinner = document.getElementById('spinner');
    spinner.style.display = 'none';
    const chart = charts[0];
    chart.addEventListener('click', (e) => {
        e.preventDefault();
        spinner.style.display = '';
        const request = new XMLHttpRequest();
        request.open('GET', '/pool/chart/update', true);
        request.onload = () => {
            if (this.status >= 200 && this.status < 400) {
                spinner.innerHTML = '<div class="green bigger-120"><span class="fas fa-check-circle green"></span> Chart updated!</div>';
            }
        };
        request.send();
    });
}


//update the score (event)
const scores = document.querySelectorAll('.score');

scores.forEach((score) => {
    //get rid of the classes just in case
    score.addEventListener('focus', (e) => {
        e.preventDefault();
        const id = score.getAttribute('id');
        const input = document.getElementById(id);
        input.classList.remove('green');
        input.classList.remove('bigger-110');
    });

    //sends the request, updates classes, triggers snackbar
    score.addEventListener('change', (e) => {
        e.preventDefault();
        const _token = $('meta[name="csrf-token"]').attr('content');
        const val = e.target.value;
        if (val >= 0 && val <= 15) {
            const id = score.getAttribute('id');
            const team = e.target.dataset.team;
            const event = e.target.dataset.event;
            const field = e.target.dataset.field;
            const form = document.getElementById('form_' + event + '_' + id);
            const spinner = document.getElementById('spinner_' + event + '_' + id);
            form.style.display = 'none';
            spinner.style.display = '';
            const request = new XMLHttpRequest();
            request.open('PUT', '/pool/score/update', true);
            request.setRequestHeader('Content-type', 'application/json; charset=utf-8');
            const data = {
                team: team,
                event: event,
                val: val,
                field: field,
                _token: _token
            };
            request.onload = function () {
                const response = JSON.parse(request.responseText);
                if (response.type === 'success') {
                    form.style.display = '';
                    spinner.style.display = 'none';
                    score.classList.add('green');
                    score.classList.add('bigger-110');
                    snackbar('Your score has been updated to <strong>' + val + '</strong>', 'bg-success');
                } else {
                    snackbar('Something went wrong<br>Do you have access?<br>Reload the page', 'bg-warning');
                }
            };
            request.send(JSON.stringify(data));
        } else {
            const old_score = score.getAttribute('value');
            score.value = old_score;
            snackbar(
                'The score <strong>' + val + '</strong> is not valid! Reset to <strong>' + old_score + '</strong>.',
                'bg-warning'
            );
        }
    });
});

function snackbar(message, bg) {
    const y = document.getElementById("snackbar");
    y.className = bg + ' black show';
    y.innerHTML = message;
    setTimeout(function () {
        y.className = "bg-success black";
        y.innerHTML = '';
    }, 4000);
}

