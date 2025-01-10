<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('unit', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->string('name', 255);
            $table->timestamps();
            $table->integer('county_id')->unsigned();
            $table->enum('school_type', ['unit.none', 'unit.primary', 'unit.secondary']);

            $table->foreign('county_id')->references('id')->on('counties');
        });
    }

    public function down()
    {
        Schema::drop('unit');
    }
};
