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
        for ($i = 1; $i <= 13; ++$i) {
            $work = new QuestionnaireCategory;
            $work->label = 'factors.work' . $i;
            $work->name = 'work' . $i;
            $work->show_bar = 1;
            $work->health = 1;
            $work->page_name = 'work';
            $work->save();
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
