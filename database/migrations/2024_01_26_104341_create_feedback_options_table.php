<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feedback_options', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->foreignId('feedback_question_id')->references('id')->on('feedback_questions')->cascadeOnDelete();
            $table->string('text');
            $table->string('value');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback_options');
    }
};
