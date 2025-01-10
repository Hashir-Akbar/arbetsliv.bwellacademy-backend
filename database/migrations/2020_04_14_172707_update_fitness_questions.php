<?php

use App\QuestionnaireCategory;
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
        $category = QuestionnaireCategory::where('name', 'fitness')->first();

        $questions = QuestionnaireQuestion::whereIn('form_name', ['step', 'bicycle', 'walk', 'mlo2', 'beep'])->get();

        foreach ($questions as $question) {
            $question->category_id = $category->id;
            $question->save();
        }
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
