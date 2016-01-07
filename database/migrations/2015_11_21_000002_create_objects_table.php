<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('object_number');
            $table->string('title');
            $table->string('work_pid');
            $table->string('artist_id');
            $table->foreign('artist_id')->references('artist_id')->on('artists');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('objects');
    }
}
