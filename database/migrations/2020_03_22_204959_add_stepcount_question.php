<?php

use App\QuestionnaireCategory;
use App\QuestionnaireGroup;
use App\QuestionnaireQuestion;
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
        $group = QuestionnaireGroup::where('label_sv', 'Stegräkning')->first();
        $category = QuestionnaireCategory::where('name', 'stepcount')->first();

        $question = new QuestionnaireQuestion;
        $question->group_id = $group->id;
        $question->category_id = $category->id;
        $question->type_id = 1;
        $question->form_name = 'stepcount';
        $question->label_sv = 'Stegräkning';
        $question->label_en = 'Step count';
        $question->description_sv = 'Hur många steg går du i genomsnitt per dag under en vecka?';
        $question->description_en = 'How many steps do you walk on average per day over a week?';
        $question->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        QuestionnaireQuestion::where('form_name', 'stepcount')->delete();
    }
};
