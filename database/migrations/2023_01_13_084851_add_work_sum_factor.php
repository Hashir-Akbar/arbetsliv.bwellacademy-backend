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
        QuestionnaireCategory::create([
            'label' => 'factors.workSum',
            'name' => 'workSum',
            'show_bar' => 0,
            'health' => 1,
            'page_name' => 'work',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        QuestionnaireCategory::where('name', 'workSum')->delete();
    }
};
