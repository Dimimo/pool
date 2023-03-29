<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Jobs;

use Dimimo\Pool\Http\Controllers\CycleController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Psr\SimpleCache\InvalidArgumentException;

class PoolChart implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The current cycle we are working on (required)
     */
    protected string $cycle;

    /**
     * Create a new job instance.
     */
    public function __construct(string $cycle)
    {
        $this->cycle = $cycle;
    }

    /**
     * Execute the job.
     *
     * @throws InvalidArgumentException
     */
    public function handle(): void
    {
        $cycleController = new CycleController();
        $cycleController->updateChart($this->cycle);
    }
}
