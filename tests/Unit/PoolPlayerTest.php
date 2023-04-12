<?php

namespace Unit;

use Dimimo\Pool\Models\PoolPlayer;
use Dimimo\Pool\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoolPlayerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_player_has_a_user_id()
    {
        /** @var PoolPlayer $player */
        $player = PoolPlayer::factory()->create(['user_id' => 1]);
        $this->assertEquals(1, $player->user_id);
    }

    /** @test */
    public function a_player_has_a_name()
    {
        /** @var PoolPlayer $player */
        $player = PoolPlayer::factory()->create(['name' => 'My Name']);
        $this->assertEquals('My Name', $player->name);
    }

    /** @test */
    public function a_player_has_a_gender()
    {
        /** @var PoolPlayer $player */
        $player = PoolPlayer::factory()->create(['gender' => 'M']);
        $this->assertEquals('M', $player->gender);
    }

    /** @test */
    public function a_player_is_a_captain()
    {
        /** @var PoolPlayer $player */
        $player = PoolPlayer::factory()->create(['captain' => true]);
        $this->assertTrue($player->captain);
    }

    /** @test */
    public function a_player_has_a_contact_number()
    {
        /** @var PoolPlayer $player */
        $player = PoolPlayer::factory()->create(['contact_nr' => '0999 999 999']);
        $this->assertEquals('0999 999 999', $player->contact_nr);
    }

    /** @test */
    public function a_player_has_a_cycle()
    {
        /** @var PoolPlayer $player */
        $player = PoolPlayer::factory()->create(['cycle' => '0000/00']);
        $this->assertEquals('0000/00', $player->cycle);
    }

    /** @test */
    public function a_player_has_a_pool_team_id()
    {
        /** @var PoolPlayer $player */
        $player = PoolPlayer::factory()->create(['pool_team_id' => 1]);
        $this->assertEquals(1, $player->pool_team_id);
    }
}
