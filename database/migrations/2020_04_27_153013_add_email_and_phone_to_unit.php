<?php

use App\Unit;
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
        Schema::table('unit', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
        });

        $units = Unit::all();
        foreach ($units as $unit) {
            if (! is_null($unit->customer)) {
                $unit->email = $unit->customer->email;
                $unit->phone = $unit->customer->phone;
                $unit->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('phone');
        });
    }
};
