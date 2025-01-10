<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feedback_answers', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->integer('profile_id')->unsigned();
            $table->string('name')->index();
            $table->string('value');
            $table->timestamps();

            $table->foreign('profile_id')->references('id')->on('profiles')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback_answers');
    }
};
