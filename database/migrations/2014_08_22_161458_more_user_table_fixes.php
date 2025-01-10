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
        Schema::create('groups', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', 255);
        });

        Schema::table('users', function ($table) {
            $table->integer('section_id')->unsigned()->nullable();

            $table->foreign('section_id')->references('id')->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_groups');

        Schema::table('users', function ($table) {
            $table->dropForeign('users_section_id_foreign');
            $table->dropColumn('section_id');
        });
    }
};
