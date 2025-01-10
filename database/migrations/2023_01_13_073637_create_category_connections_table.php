<?php

use App\QuestionnaireCategory;
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
        Schema::create('category_connections', function (Blueprint $table) {
            $table->foreignIdFor(QuestionnaireCategory::class, 'category_id');
            $table->foreignIdFor(QuestionnaireCategory::class, 'affected_by_id');

            $table->primary(['category_id', 'affected_by_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_connections');
    }
};
