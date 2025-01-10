<?php

use App\QuestionnaireQuestion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('questionnaire_questions', function (Blueprint $table) {
            $table->string('label_sv')->nullable();
            $table->string('label_en')->nullable();
            $table->text('description_sv')->nullable();
            $table->text('description_en')->nullable();
            $table->text('help_sv')->nullable();
            $table->text('help_en')->nullable();
        });
        $questions = QuestionnaireQuestion::all();
        foreach ($questions as $question) {
            $question->label_sv = t($question->label);
            $question->description_sv = t($question->description);
            $question->help_sv = t($question->help);
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
        Schema::table('questionnaire_questions', function (Blueprint $table) {
            $table->dropColumn('label_sv');
            $table->dropColumn('label_en');
            $table->dropColumn('description_sv');
            $table->dropColumn('description_en');
            $table->dropColumn('help_sv');
            $table->dropColumn('help_en');
        });
    }
};
