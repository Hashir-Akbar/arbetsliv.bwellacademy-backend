<?php

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
            $table->string('poster_sv_url')->nullable();
            $table->string('poster_sv_text')->nullable();
            $table->string('poster_en_url')->nullable();
            $table->string('poster_en_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questionnaire_questions', function (Blueprint $table) {
            $table->dropColumn('poster_en_text');
            $table->dropColumn('poster_en_url');
            $table->dropColumn('poster_sv_text');
            $table->dropColumn('poster_sv_url');
        });
    }
};
