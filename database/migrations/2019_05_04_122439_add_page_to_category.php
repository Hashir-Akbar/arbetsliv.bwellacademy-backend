<?php

use App\QuestionnaireCategory;
use App\QuestionnaireGroup;
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
        if (! Schema::hasColumn('questionnaire_categories', 'page_name')) {
            Schema::table('questionnaire_categories', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->string('page_name', 255);
                // $table->boolean('disabled');
            });

            for ($i = 1; $i < 64; ++$i) {
                $cat = QuestionnaireCategory::find($i);
                $question = QuestionnaireQuestion::where('category_id', $i)->first();
                if ($question) {
                    // $group_id = ->group_id;
                    // $group = QuestionnaireGroup::find($group_id);
                    $cat->page_name = $question->group->page->name;
                    // $cat->page_name = $group->page->name;
                    $cat->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('questionnaire_categories', function (Blueprint $table) {
        //     $table->dropColumn('page_name');
        // });
    }
};
