<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

$api    = app('Dingo\Api\Routing\Router');
$prefix = 'App\Http\Controllers\Api\Pool\\';
$api->version('v1', function (\Dingo\Api\Routing\Router $api) use ($prefix)
{
    $api->group(['prefix' => 'pool'], function (\Dingo\Api\Routing\Router $api) use ($prefix)
    {
        $api->get('get_seasons', ['as' => 'api.pool.seasons', 'uses' => $prefix . 'SeasonController@getAllSeasons']);
        $api->post('change_season', ['as' => 'api.pool.season', 'uses' => $prefix . 'SeasonController@changeSeason']);
        $api->get('results', ['as' => 'api.pool.results', 'uses' => $prefix . 'ResultsController@results']);
        $api->get('calendar', ['as' => 'api.pool.calendar', 'uses' => $prefix . 'CalendarController@calendar']);
        $api->get('team/{team_id}', ['as' => 'api.pool.team', 'uses' => $prefix . 'TeamController@show']);
        $api->get('team_list', ['as' => 'api.pool.team.index', 'uses' => $prefix . 'TeamController@index']);
    });
});
