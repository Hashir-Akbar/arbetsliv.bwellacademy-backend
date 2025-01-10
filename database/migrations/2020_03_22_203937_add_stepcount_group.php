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
        $group = new QuestionnaireGroup;
        $group->page_id = 1;
        $group->type_id = 2;
        $group->hide_label = 1;
        $group->weight = 30;
        $group->label_sv = 'Stegräkning';
        $group->label_en = 'Step count';
        $group->save();
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
