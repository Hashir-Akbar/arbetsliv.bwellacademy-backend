<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('questionnaire_categories')->insert([
            'id' => 99,
            'label' => 'factors.physicalCondition',
            'name' => 'physicalCondition',
            'show_bar' => 1,
            'health' => 1,
            'page_name' => 'physical_questions',
        ]);
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
