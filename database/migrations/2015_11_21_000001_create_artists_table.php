<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('artist_id');
            $table->string('slug');
            $table->string('name');
            $table->string('year_birth');
            $table->string('year_death');
            $table->string('PID');
            $table->integer('copyright');
            $table->timestamps();
            $table->unique('artist_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('artists');
    }
}
