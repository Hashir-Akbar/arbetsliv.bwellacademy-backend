<?php

use App\QuestionnaireGroup;
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
        Schema::table('questionnaire_groups', function (Blueprint $table) {
            $table->string('label_sv')->nullable();
            $table->string('label_en')->nullable();
        });
        $groups = QuestionnaireGroup::all();
        foreach ($groups as $group) {
            $group->label_sv = t($group->label);
            $group->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questionnaire_groups', function (Blueprint $table) {
            $table->dropColumn('label_sv');
            $table->dropColumn('label_en');
        });
    }
};
