/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/pool-score.js":
/*!************************************!*\
  !*** ./resources/js/pool-score.js ***!
  \************************************/
/***/ (function() {

var _this = this;
/*
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

//update the chart
var charts = document.getElementsByClassName('chart-update-request');
//check if charts have values, if not, skip the rest, this is only for admins
if (charts.length > 0) {
  var spinner = document.getElementById('spinner');
  spinner.style.display = 'none';
  var chart = charts[0];
  chart.addEventListener('click', function (e) {
    e.preventDefault();
    spinner.style.display = '';
    var request = new XMLHttpRequest();
    request.open('GET', '/pool/chart/update', true);
    request.onload = function () {
      if (_this.status >= 200 && _this.status < 400) {
        spinner.innerHTML = '<div class="green bigger-120"><span class="fas fa-check-circle green"></span> Chart updated!</div>';
      }
    };
    request.send();
  });
}

//update the score (event)
var scores = document.querySelectorAll('.score');
scores.forEach(function (score) {
  //get rid of the classes just in case
  score.addEventListener('focus', function (e) {
    e.preventDefault();
    var id = score.getAttribute('id');
    var input = document.getElementById(id);
    input.classList.remove('green');
    input.classList.remove('bigger-110');
  });

  //sends the request, updates classes, triggers snackbar
  score.addEventListener('change', function (e) {
    e.preventDefault();
    var _token = $('meta[name="csrf-token"]').attr('content');
    var val = e.target.value;
    if (val >= 0 && val <= 15) {
      var id = score.getAttribute('id');
      var team = e.target.dataset.team;
      var event = e.target.dataset.event;
      var field = e.target.dataset.field;
      var form = document.getElementById('form_' + event + '_' + id);
      var _spinner = document.getElementById('spinner_' + event + '_' + id);
      form.style.display = 'none';
      _spinner.style.display = '';
      var request = new XMLHttpRequest();
      request.open('PUT', '/pool/score/update', true);
      request.setRequestHeader('Content-type', 'application/json; charset=utf-8');
      var data = {
        team: team,
        event: event,
        val: val,
        field: field,
        _token: _token
      };
      request.onload = function () {
        var response = JSON.parse(request.responseText);
        if (response.type === 'success') {
          form.style.display = '';
          _spinner.style.display = 'none';
          score.classList.add('green');
          score.classList.add('bigger-110');
          snackbar('Your score has been updated to <strong>' + val + '</strong>', 'bg-success');
        } else {
          snackbar('Something went wrong<br>Do you have access?<br>Reload the page', 'bg-warning');
        }
      };
      request.send(JSON.stringify(data));
    } else {
      var old_score = score.getAttribute('value');
      score.value = old_score;
      snackbar('The score <strong>' + val + '</strong> is not valid! Reset to <strong>' + old_score + '</strong>.', 'bg-warning');
    }
  });
});
function snackbar(message, bg) {
  var y = document.getElementById("snackbar");
  y.className = bg + ' black show';
  y.innerHTML = message;
  setTimeout(function () {
    y.className = "bg-success black";
    y.innerHTML = '';
  }, 4000);
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module is referenced by other modules so it can't be inlined
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/pool-score.js"]();
/******/ 	
/******/ })()
;