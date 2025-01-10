<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $mentors = User::where('is_mentor', 1)->get();

        DB::beginTransaction();

        foreach($mentors as $mentor)
        {
            if (!$mentor->is_superadmin && !$mentor->is_staff && !$mentor->is_admin && !$mentor->is_nurse && !$mentor->is_physical_trainer)
            {
               $mentor->delete();
            }
        }

        DB::commit();

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_mentor');
        });

        Schema::drop('mentors');
    }

    public function down(): void
    {
        // No
    }
};
