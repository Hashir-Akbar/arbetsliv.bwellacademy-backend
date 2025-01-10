<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('first_name', 128);
            $table->string('last_name', 255);
            $table->string('email', 255)->nullable();
            $table->string('password', 128)->nullable();
            $table->string('remember_token')->nullable();
            $table->integer('registration_code')->nullable();
            $table->enum('sex', ['M', 'F']);
            $table->date('birth_date')->nullable();
            $table->string('birth_code', 4)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('users');
    }
};
