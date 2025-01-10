<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (config('fms.type') !== 'work') {
            return;
        }

        Schema::table('unit', function (Blueprint $table) {
            $table->foreignId('business_category_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (config('fms.type') !== 'work') {
            return;
        }

        Schema::table('unit', function (Blueprint $table) {
            $table->dropForeign('business_category_id');
            $table->dropColumn('business_category_id');
        });
    }
};
