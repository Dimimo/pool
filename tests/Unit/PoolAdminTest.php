<?php

namespace Unit;

use Dimimo\Pool\Models\PoolAdmin;
use Dimimo\Pool\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoolAdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_has_a_user_id()
    {
        /** @var PoolAdmin $admin */
        $admin = PoolAdmin::factory()->create(['user_id' => 1]);
        $this->assertEquals(1, $admin->user_id);
    }

    /** @test */
    public function an_admin_has_a_database()
    {
        /** @var PoolAdmin $admin */
        $admin = PoolAdmin::factory()->create(['database' => 'mysql']);
        $this->assertEquals('mysql', $admin->database);
    }
}
