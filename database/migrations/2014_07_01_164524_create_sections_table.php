<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('unit_id')->unsigned();
            $table->string('name', 255);
            $table->enum('type', ['section.divison', 'section.class']);
            $table->timestamps();
            $table->integer('school_year')->unsigned();
            $table->integer('program_id')->unsigned()->nullable();

            $table->foreign('program_id')->references('id')->on('secondary_programs');
        });
    }

    public function down()
    {
        Schema::drop('sections');
    }
};
