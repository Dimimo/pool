<?php

namespace Unit;

use Dimimo\Pool\Models\PoolEvent;
use Dimimo\Pool\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoolEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_event_has_a_score1()
    {
        /** @var PoolEvent $event */
        $event = PoolEvent::factory()->create(['score1' => 1]);
        $this->assertEquals(1, $event->score1);
    }

    /** @test */
    public function an_event_has_a_score2()
    {
        /** @var PoolEvent $event */
        $event = PoolEvent::factory()->create(['score2' => 1]);
        $this->assertEquals(1, $event->score2);
    }

    /** @test */
    public function an_event_has_a_pool_date_id()
    {
        /** @var PoolEvent $event */
        $event = PoolEvent::factory()->create(['pool_date_id' => 1]);
        $this->assertEquals(1, $event->pool_date_id);
    }

    /** @test */
    public function an_event_has_a_pool_venue_id()
    {
        /** @var PoolEvent $event */
        $event = PoolEvent::factory()->create(['pool_venue_id' => 1]);
        $this->assertEquals(1, $event->pool_venue_id);
    }

    /** @test */
    public function an_event_has_a_team1()
    {
        /** @var PoolEvent $event */
        $event = PoolEvent::factory()->create(['team1' => 1]);
        $this->assertEquals(1, $event->team1);
    }

    /** @test */
    public function an_event_has_a_team2()
    {
        /** @var PoolEvent $event */
        $event = PoolEvent::factory()->create(['team2' => 1]);
        $this->assertEquals(1, $event->team2);
    }

    /** @test */
    public function an_event_has_a_remark()
    {
        /** @var PoolEvent $event */
        $event = PoolEvent::factory()->create(['remark' => 'A remark']);
        $this->assertEquals('A remark', $event->remark);
    }
}
