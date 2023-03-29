<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Commands;

use Dimimo\Pool\Jobs\PoolSetDayScores;
use Dimimo\Pool\Models\PoolDate;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PoolScoresSetDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pool:scores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the daily pool scores to zero to activate Live Scores';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $today = Carbon::now()->format('Y-m-d');
        $dates = PoolDate::where('date', $today)->get();
        foreach ($dates as $date) {
            PoolSetDayScores::dispatch($date);
        }
        $dates->count() ? $count = $dates->count() : $count = 'No';
        $message = "The daily Pool score for $today has been run. $count reset requests has been dispatched.";
        \Log::info('[PoolScoreSetDay] '.$message);
        $this->comment($message);
    }
}
