<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePoolTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if ( ! Schema::hasTable('pool_teams'))
        {
            Schema::create('pool_teams', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->integer('pool_venue_id')
                    ->unsigned()
                    ->index();
                $table->text('remark')
                    ->nullable();
                $table->string('cycle', 7)
                    ->index();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('pool_teams');
    }
}
