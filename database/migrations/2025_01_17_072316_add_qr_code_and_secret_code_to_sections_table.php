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
        Schema::table('sections', function (Blueprint $table) {
            $table->text('qr_code')->nullable()->collation('utf8mb4_unicode_ci'); // Add qr_code column
            $table->string('secret_code')->nullable()->collation('utf8mb4_unicode_ci'); // Add secret_code column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('qr_code'); // Remove qr_code column
            $table->dropColumn('secret_code'); // Remove secret_code column
        });
    }
};
