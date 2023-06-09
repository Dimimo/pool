<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Listeners;

use Dimimo\Pool\Events\ScoreEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class ScoreListener
 */
class ScoreEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(ScoreEvent $event): ScoreEvent
    {
        return $event;
    }
}
