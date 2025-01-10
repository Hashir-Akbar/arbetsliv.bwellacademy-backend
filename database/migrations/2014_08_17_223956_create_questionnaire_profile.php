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
        Schema::create('profiles', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->date('date');

            $table->timestamps();

            $table->integer('health_count');
            $table->integer('risk_count');
            $table->integer('unknown_count');

            $table->text('notes');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('modified_by')->references('id')->on('users');
        });

        Schema::create('profile_values', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('profile_id')->unsigned();
            $table->string('name', 128);
            $table->float('value');

            $table->foreign('profile_id')->references('id')->on('profiles');
        });

        Schema::create('profile_texts', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('profile_id')->unsigned();
            $table->string('name', 128);
            $table->text('content');

            $table->foreign('profile_id')->references('id')->on('profiles');
        });

        Schema::create('profile_factors', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('profile_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->float('value')->nullable();
            $table->enum('status', ['profile.unknown', 'profile.risk', 'profile.healthy']);

            $table->foreign('profile_id')->references('id')->on('profiles');
            $table->foreign('category_id')->references('id')->on('questionnaire_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profile_factors');
        Schema::drop('profile_texts');
        Schema::drop('profile_values');
        Schema::drop('profiles');
    }
};
