<?php

use App\QuestionnaireGroup;
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
        $kropp = QuestionnaireGroup::find(26);
        $kropp->page_id = 1;
        $kropp->weight = 22;
        $kropp->save();
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
