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
        Schema::create('unit_staff', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('unit_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('unit_id')->references('id')->on('unit')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('unit_staff');
    }
};
