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
        Schema::create('questionnaire_page', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('weight');
        });

        Schema::create('questionnaire_groups', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('page_id')->unsigned();
            $table->integer('weight');

            $table->foreign('page_id')->references('id')->on('questionnaire_page')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('questionnaire_categories', function ($table) {
            $table->increments('id');
            $table->string('label');
        });

        Schema::create('questionnaire_element_types', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', 255);
            $table->string('template_name', 255);
        });

        Schema::create('questionnaire_group_types', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', 255);
            $table->string('template_name', 255);
        });

        Schema::create('questionnaire_questions', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('group_id')->unsigned();
            $table->integer('category_id')->unsigned()->nullable();
            $table->string('form_name', 255);
            $table->integer('type_id')->unsigned();
            $table->string('data', 255);
            $table->integer('weight');

            $table->foreign('group_id')->references('id')->on('questionnaire_groups')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('category_id')->references('id')->on('questionnaire_categories');

            $table->foreign('type_id')->references('id')->on('questionnaire_element_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('questionnaire_category_access', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('category_id')
                ->references('id')
                ->on('questionnaire_categories')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('questionnaire_questions');
        Schema::drop('questionnaire_element_types');
        Schema::drop('questionnaire_group_types');
        Schema::drop('questionnaire_category_access');
        Schema::drop('questionnaire_categories');
        Schema::drop('questionnaire_groups');
        Schema::drop('questionnaire_page');
    }
};
