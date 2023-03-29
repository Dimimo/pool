<?php

use Dimimo\Pool\Http\Controllers\CycleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------\
| The billiard competition | The REGEX to get to a cycle data dddd/dd is ([\d]{4}\/[\d]{2})
---------------------------/
|*/
Route::get('/', [CycleController::class, 'index'])->name('pool.index');
Route::get('calendar', [CycleController::class, 'calendar'])->name('pool.calendar');
Route::get('cycle/{cycle}', [CycleController::class, 'cycle'])->name('pool.cycle');
Route::get('all_seasons', [CycleController::class, 'allSeasons'])->name('pool.all_seasons');
Route::get('date/show/{date_id}', [CycleController::class, 'showDate'])->name('pool.date.show');
Route::get('new_season/{id}', [CycleController::class, 'newSeason'])->name('pool.new_season');
Route::post('new_season', [CycleController::class, 'newSeasonCreate'])->name('pool.new_season.create');
Route::get('date/create', [CycleController::class, 'createDate'])->name('pool.date.create');
Route::post('date/store', [CycleController::class, 'storeDate'])->name('pool.date.store');
Route::get('date/{id}/edit', [CycleController::class, 'editDate'])->name('pool.date.edit');
Route::put('date/{id}/edit', [CycleController::class, 'updateDate'])->name('pool.date.update');
Route::get('dates/edit', [CycleController::class, 'editDates'])->name('pool.dates.edit');
Route::put('dates/edit', [CycleController::class, 'updateDates'])->name('pool.dates.update');
Route::delete('date/{id}/destroy', [CycleController::class, 'deleteDate'])->name('pool.date.destroy');
Route::get('event/create', [CycleController::class, 'createEvent'])->name('pool.event.create');
Route::post('event/store', [CycleController::class, 'storeEvent'])->name('pool.event.store');
Route::get('event/{id}/edit', [CycleController::class, 'editEvent'])->name('pool.event.edit');
Route::put('event/{id}/edit', [CycleController::class, 'updateEvent'])->name('pool.event.update');
Route::delete('event/{id}/destroy', [CycleController::class, 'deleteEvent'])->name('pool.event.destroy');
Route::get('player/create', [CycleController::class, 'createPlayer'])->name('pool.player.create');
Route::post('player/store', [CycleController::class, 'storePlayer'])->name('pool.player.store');
Route::get('players/{team}/edit', [CycleController::class, 'editPlayers'])->name('pool.players.edit');
Route::put('player/{id}/edit', [CycleController::class, 'updatePlayer'])->name('pool.player.update');
Route::delete('player/{id}/delete', [CycleController::class, 'deletePlayer'])->name('pool.player.delete');
Route::get('teams', [CycleController::class, 'teams'])->name('pool.teams');
Route::get('team/show/{id}', [CycleController::class, 'showTeam'])->name('pool.team.show');
Route::get('team/create/{venue_id?}', [CycleController::class, 'createTeam'])->name('pool.team.create');
Route::post('team/store', [CycleController::class, 'storeTeam'])->name('pool.team.store');
Route::get('team/{id}/edit', [CycleController::class, 'editTeam'])->name('pool.team.edit');
Route::put('team/{id}/edit', [CycleController::class, 'updateTeam'])->name('pool.team.update');
Route::delete('team/{id}/delete', [CycleController::class, 'deleteTeam'])->name('pool.team.delete');
Route::get('venue/show/{id}', [CycleController::class, 'showVenue'])->name('pool.venue.show');
Route::get('venue/create', [CycleController::class, 'createVenue'])->name('pool.venue.create');
Route::post('venue/store', [CycleController::class, 'storeVenue'])->name('pool.venue.store');
Route::get('venue/{id}/edit', [CycleController::class, 'editVenue'])->name('pool.venue.edit');
Route::put('venue/{id}/edit', [CycleController::class, 'updateVenue'])->name('pool.venue.update');
Route::delete('venue/{id}/delete', [CycleController::class, 'deleteVenue'])->name('pool.venue.delete');
Route::put('score/update', [CycleController::class, 'updateScore'])->name('pool.score.update');
Route::get('chart/update', [CycleController::class, 'updateChart'])->name('pool.chart.update');
Route::post('overview/update/{score_id?}', [CycleController::class, 'returnTableUpdate'])->name('pool.table.update');
Route::get('login', [CycleController::class, 'login'])->name('pool.login')->middleware('auth');
Route::get('logout', [CycleController::class, 'logout'])->name('pool.logout');
Route::get('day-schedule/{event?}', [CycleController::class, 'daySchedule'])->name('pool.day.schedule');
