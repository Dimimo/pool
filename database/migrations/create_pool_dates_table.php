<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePoolDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if ( ! Schema::hasTable('pool_dates'))
        {
            Schema::create('pool_dates', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('date');
                $table->boolean('regular')
                    ->index();
                $table->string('title')
                    ->nullable();
                $table->string('cycle', 7)
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
        Schema::dropIfExists('pool_dates');
    }
}
