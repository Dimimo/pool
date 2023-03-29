<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace Dimimo\Pool\Events;

use Dimimo\Pool\Models\PoolEvent;
//use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ScoreEvent
 */
class ScoreEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public PoolEvent $score;

    /**
     * Create a new event instance.
     *
     *
     * @return void
     */
    public function __construct(PoolEvent $score)
    {
        $this->score = $score;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return ['pool-score'];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'score-event';
    }
}
