<?php

use App\QuestionnairePage;
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
        Schema::table('questionnaire_page', function (Blueprint $table) {
            $table->string('label_sv')->nullable();
            $table->string('label_en')->nullable();
            $table->text('description_sv')->nullable();
            $table->text('description_en')->nullable();
        });
        $pages = QuestionnairePage::all();
        foreach ($pages as $page) {
            $page->label_sv = t($page->label);
            $page->description_sv = t($page->description);
            $page->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questionnaire_page', function (Blueprint $table) {
            $table->dropColumn('label_sv');
            $table->dropColumn('label_en');
            $table->dropColumn('description_sv');
            $table->dropColumn('description_en');
        });
    }
};
