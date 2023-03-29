<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoolEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if ( ! Schema::hasTable('pool_events'))
        {
            Schema::create('pool_events', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('pool_date_id')
                    ->unsigned()
                    ->index();
                $table->integer('pool_venue_id')
                    ->unsigned()
                    ->index();
                $table->integer('team1')
                    ->unsigned()
                    ->index();
                $table->integer('team2')
                    ->unsigned()
                    ->index();
                $table->integer('score1')
                    ->unsigned()
                    ->nullable()
                    ->index();
                $table->integer('score2')
                    ->unsigned()
                    ->nullable()
                    ->index();
                $table->text('remark')
                    ->nullable();
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
        Schema::dropIfExists('pool_events');
    }
}
