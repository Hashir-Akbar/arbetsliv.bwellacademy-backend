<?php

use App\QuestionnaireCategory;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $factor = new QuestionnaireCategory;
        $factor->label = 'factors.strength2';
        $factor->name = 'strength2';
        $factor->show_bar = 1;
        $factor->health = 1;
        $factor->page_name = 'physical';
        $factor->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
