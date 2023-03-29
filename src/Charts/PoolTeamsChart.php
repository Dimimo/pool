<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class PoolTeamsChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @param int $number_of_teams
     */
    public function __construct(int $number_of_teams)
    {
        parent::__construct();
        $this->options([
                           'maintainAspectRatio' => false,
                           'scales'              => [
                               'xAxes' => [
                                   [
                                       'scaleLabel' => [
                                           'display'     => true,
                                           'labelString' => 'Week',
                                       ],
                                       'ticks'      => [
                                           'min' => 1,
                                       ],
                                   ],
                               ],
                               'yAxes' => [
                                   [
                                       'scaleLabel' => [
                                           'display'     => true,
                                           'labelString' => 'Position',
                                       ],
                                       'ticks'      => [
                                           'beginAtZero' => true,
                                           'mirror'      => false,
                                           'min'         => 1,
                                           'max'         => $number_of_teams,
                                           'reverse'     => true,
                                       ],
                                   ],
                               ],
                           ],
                       ]);
    }
}
