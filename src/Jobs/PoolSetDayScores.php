<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Jobs;

use Dimimo\Pool\Models\PoolDate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PoolSetDayScores implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected PoolDate $date;

    /**
     * Create a new job instance.
     *
     * @param  PoolDate  $date
     * return void
     */
    public function __construct(PoolDate $date)
    {
        $this->date = $date;
    }

    /**
     * Check for events today, if they exist, set the scores to 0-0
     */
    public function handle(): void
    {
        if ($this->date->events()->count() > 0) {
            foreach ($this->date->events as $event) {
                if (! $event->score1 && ! $event->score2) {
                    if ($event->team_1->id !== $event->team_2->id || $event->team_2->name !== 'BYE') {
                        $event->update(['score1' => 0, 'score2' => 0]);
                    }
                }
            }
        }
    }
}
