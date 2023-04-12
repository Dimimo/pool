<?php

namespace Unit;

use Dimimo\Pool\Models\PoolVenue;
use Dimimo\Pool\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoolVenueTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_venue_has_a_name()
    {
        /** @var PoolVenue $venue */
        $venue = PoolVenue::factory()->create(['name' => 'Venue Name']);
        $this->assertEquals('Venue Name', $venue->name);
    }

    /** @test */
    public function a_venue_has_an_address()
    {
        /** @var PoolVenue $venue */
        $venue = PoolVenue::factory()->create(['address' => 'Venue Address']);
        $this->assertEquals('Venue Address', $venue->address);
    }

    /** @test */
    public function a_venue_has_a_contact_name()
    {
        /** @var PoolVenue $venue */
        $venue = PoolVenue::factory()->create(['contact_name' => 'Venue Contact']);
        $this->assertEquals('Venue Contact', $venue->contact_name);
    }

    /** @test */
    public function a_venue_has_a_contact_nr()
    {
        /** @var PoolVenue $venue */
        $venue = PoolVenue::factory()->create(['contact_nr' => '0999 999 999']);
        $this->assertEquals('0999 999 999', $venue->contact_nr);
    }

    /** @test */
    public function a_venue_has_a_remark()
    {
        /** @var PoolVenue $venue */
        $venue = PoolVenue::factory()->create(['remark' => 'Venue Remark']);
        $this->assertEquals('Venue Remark', $venue->remark);
    }
}
