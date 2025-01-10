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
        $category = new QuestionnaireCategory;
        $category->label = 'factors.stepcount';
        $category->name = 'stepcount';
        $category->show_bar = 1;
        $category->health = 1;
        $category->page_name = 'physical';
        $category->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        QuestionnaireCategory::where('name', 'stepcount')->delete();
    }
};
