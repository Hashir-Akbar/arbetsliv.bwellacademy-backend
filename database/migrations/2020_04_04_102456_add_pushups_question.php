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
        $group = QuestionnaireGroup::where('label_sv', 'Fysiska tester')->first();
        $category = QuestionnaireCategory::where('name', 'strArms')->first();

        $question = new QuestionnaireQuestion;
        $question->group_id = $group->id;
        $question->category_id = $category->id;
        $question->type_id = 1;
        $question->weight = 3;
        $question->form_name = 'pushups';
        $question->label_sv = 'Armböjningar';
        $question->label_en = 'Push-ups';
        $question->description_sv = 'Hur många armböjningar klarar du på 1 minut?';
        $question->description_en = 'How many push-ups can you do in 1 minute?';
        $question->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        QuestionnaireQuestion::where('form_name', 'pushups')->delete();
    }
};
