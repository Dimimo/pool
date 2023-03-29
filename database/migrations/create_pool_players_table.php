<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePoolPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if ( ! Schema::hasTable('pool_players'))
        {
            Schema::create('pool_players', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('user_id')
                    ->unsigned()
                    ->nullable()
                    ->index();
                $table->string('name');
                $table->enum('gender', ['M', 'F'])
                    ->nullable();
                $table->integer('pool_team_id')
                    ->unsigned()
                    ->index();
                $table->boolean('captain')
                    ->index();
                $table->string('contact_nr')
                    ->nullable();
                $table->string('cycle')
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
        Schema::dropIfExists('pool_players');
    }
}
