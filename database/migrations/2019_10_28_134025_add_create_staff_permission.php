<?php

use App\Permission;
use App\PermissionRole;
use App\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $perm = new Permission;
        $perm->name = 'create_staff';
        $perm->label = 'permissions.create_staff';
        $perm->save();

        $role = Role::where('name', 'admin')->firstOrFail();

        $permRole = new PermissionRole;
        $permRole->permission_id = $perm->id;
        $permRole->role_id = $role->id;
        $permRole->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $perm = Permission::where('name', 'create_staff')->firstOrFail();

        $permRole = PermissionRole::where('permission_id', $perm->id)->first();
        $permRole->delete();

        $perm->delete();
    }
};
