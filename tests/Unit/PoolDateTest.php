<?php

namespace Unit;

use Dimimo\Pool\Models\PoolDate;
use Dimimo\Pool\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class PoolDateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_date_has_a_date()
    {
        /** @var PoolDate $date */
        $temp = Carbon::now()->format('Y-m-d');
        $date = PoolDate::factory()->create(['date' => $temp]);
        $this->assertEquals($temp, $date->date->format('Y-m-d'));
    }

    /** @test */
    public function a_date_has_a_regular()
    {
        /** @var PoolDate $date */
        $date = PoolDate::factory()->create(['regular' => true]);
        $this->assertTrue($date->regular);
    }

    /** @test */
    public function a_date_has_a_title()
    {
        /** @var PoolDate $date */
        $date = PoolDate::factory()->create(['title' => 'A title']);
        $this->assertEquals('A title', $date->title);
    }

    /** @test */
    public function a_date_has_a_cycle()
    {
        /** @var PoolDate $date */
        $date = PoolDate::factory()->create(['cycle' => '2023/05']);
        $this->assertEquals('2023/05', $date->cycle);
    }

    /** @test */
    public function a_date_has_a_remark()
    {
        /** @var PoolDate $date */
        $date = PoolDate::factory()->create(['remark' => 'A remark']);
        $this->assertEquals('A remark', $date->remark);
    }
}
