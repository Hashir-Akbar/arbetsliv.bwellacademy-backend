<?php

use App\Administrator;
use App\RoleUser;
use App\UnitStaff;
use App\User;
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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_superadmin')->default(false);
            $table->boolean('is_staff')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_mentor')->default(false);
            $table->boolean('is_nurse')->default(false);
            $table->boolean('is_physical_trainer')->default(false);
            $table->integer('unit_id')->unsigned()->nullable();
        });

        foreach (User::all() as $user) {
            $is_superadmin = RoleUser::where('user_id', $user->id)->where('role_id', 1)->count() > 0;
            $is_admin = RoleUser::where('user_id', $user->id)->where('role_id', 4)->count() > 0;
            $is_mentor = RoleUser::where('user_id', $user->id)->where('role_id', 5)->count() > 0;

            $user->is_superadmin = $is_superadmin;
            $user->is_staff = $is_admin || $is_mentor;
            $user->is_mentor = $is_mentor;
            $user->save();
        }

        foreach (Administrator::all() as $admin) {
            $user = User::find($admin->user_id);
            if (is_null($user)) {
                continue;
            }
            $user->unit_id = $admin->unit_id;
            $user->is_admin = true;
            $user->is_nurse = $admin->is_nurse;
            $user->save();
        }

        foreach (UnitStaff::all() as $staff) {
            $user = User::find($staff->user_id);
            if (is_null($user)) {
                continue;
            }
            $user->unit_id = $staff->unit_id;
            $user->is_physical_trainer = $staff->is_physical_trainer;
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_superadmin');
            $table->dropColumn('is_staff');
            $table->dropColumn('is_admin');
            $table->dropColumn('is_mentor');
            $table->dropColumn('is_nurse');
            $table->dropColumn('is_physical_trainer');
            $table->dropColumn('unit_id');
        });
    }
};
