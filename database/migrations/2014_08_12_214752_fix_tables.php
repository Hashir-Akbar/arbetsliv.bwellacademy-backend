<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', 255);
        });

        Schema::create('counties', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('country_id')->unsigned();
            $table->string('label', 255);

            $table->foreign('country_id')->references('id')->on('countries');
        });

        Schema::create('secondary_programs', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('counties');

        Schema::drop('countries');

        Schema::drop('secondary_programs');
    }
};
