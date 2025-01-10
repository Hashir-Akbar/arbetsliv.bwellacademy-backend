<?php

use App\QuestionnaireCategory;
use App\QuestionnaireLimit;
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
        $fitness = QuestionnaireCategory::find(4);
        $fitness->page_name = 'physical';
        $fitness->save();

        $snuffing = QuestionnaireLimit::find(23);
        $snuffing->risk_levels = '[5,4]';
        $snuffing->save();

        $smoking = QuestionnaireLimit::find(22);
        $smoking->risk_levels = '[5,4]';
        $smoking->save();
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
