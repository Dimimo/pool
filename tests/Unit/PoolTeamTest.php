<?php

namespace Unit;

use Dimimo\Pool\Models\PoolTeam;
use Dimimo\Pool\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoolTeamTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_team_has_a_name()
    {
        /** @var PoolTeam $team */
        $team = PoolTeam::factory()->create(['name' => 'Team Name']);
        $this->assertEquals('Team Name', $team->name);
    }

    /** @test */
    public function a_team_has_a_remark()
    {
        /** @var PoolTeam $team */
        $team = PoolTeam::factory()->create(['remark' => 'A remark']);
        $this->assertEquals('A remark', $team->remark);
    }

    /** @test */
    public function a_team_has_a_cycle()
    {
        /** @var PoolTeam $team */
        $team = PoolTeam::factory()->create(['cycle' => '0000/00']);
        $this->assertEquals('0000/00', $team->cycle);
    }

    /** @test */
    public function a_team_has_a_pool_venue_id()
    {
        /** @var PoolTeam $team */
        $team = PoolTeam::factory()->create(['pool_venue_id' => 1]);
        $this->assertEquals(1, $team->pool_venue_id);
    }
}
