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
        if (! Schema::hasColumn('profile_factors', 'improve')) {
            Schema::table('profile_factors', function (Blueprint $table) {
                $table->integer('improve')->nullable(false)->default(0);
                $table->integer('satisfied')->nullable(false)->default(0);
                $table->integer('target')->nullable(false)->default(0);
                $table->integer('page')->nullable(false)->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile_factors', function (Blueprint $table) {
            //
        });
    }
};
