<?php

namespace Dimimo\Pool\Pool\Commands;

use Illuminate\Console\Command;

class PoolCommand extends Command
{
    public $signature = 'pool';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
