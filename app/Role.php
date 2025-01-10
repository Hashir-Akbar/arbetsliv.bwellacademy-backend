<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function can($permission)
    {
        $permissions = [];

        if ($this->name == 'superadmin') {
            $permissions = [
                'admin_questionnaire',
                'create_customers',
                'create_students',
                'view_admin_menu',
                'view_statistics',
                'view_units',
                'view_users',
            ];
        } elseif ($this->name == 'admin') {
            $permissions = [
                'create_sections',
                'create_staff',
                'create_students',
                'view_admin_menu',
                'view_statistics',
                'view_units',
                'view_users',
            ];
        } elseif ($this->name == 'staff') {
            $permissions = [
                'view_users',
            ];
        }

        return in_array($permission, $permissions);
    }
}
