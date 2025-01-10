<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, TwoFactorAuthenticatable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'deactivated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'registration_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'deactivated_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['birth_date'];

    protected static function booted()
    {
        static::deleting(function ($user) {
            // delete profiles
            foreach (Profile::where('user_id', $user->id)->get() as $profile) {
                $profile->delete();
            }
        });
    }

    public function full_name()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function sexLabel()
    {
        if ($this->sex == 'M') {
            return __('general.male');
        }

        if ($this->sex == 'F') {
            return __('general.female');
        }

        return __('general.unknown');
    }

    public function isSuperAdmin()
    {
        return $this->is_superadmin;
    }

    public function isStaff()
    {
        return $this->is_staff;
    }

    public function isStudent()
    {
        return ! $this->is_superadmin && ! $this->is_staff;
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isNurse()
    {
        return $this->is_nurse;
    }

    public function isPhysicalTrainer()
    {
        return $this->is_physical_trainer;
    }

    public function hasRole($role_name)
    {
        if ($role_name == 'superadmin') {
            return $this->isSuperAdmin();
        }
        if ($role_name == 'staff') {
            return $this->isStaff();
        }
        if ($role_name == 'student') {
            return $this->isStudent();
        }
        if ($role_name == 'admin') {
            return $this->isAdmin();
        }
        if ($role_name == 'nurse') {
            return $this->isNurse();
        }
        if ($role_name == 'pe') {
            return $this->isPhysicalTrainer();
        }

        return false;
    }

    public function rolesLabel()
    {
        if ($this->isStudent()) {
            if ($this->is_test) {
                return __('roles.test-student');
            }

            return __('roles.student');
        }
        if ($this->isSuperAdmin()) {
            return __('roles.superadmin');
        }
        if ($this->isStaff()) {
            $labels = [];
            if ($this->isAdmin()) {
                $labels[] = __('roles.admin');
            }
            if ($this->isNurse()) {
                $labels[] = __('roles.nurse');
            }
            if ($this->isPhysicalTrainer()) {
                $labels[] = __('roles.physical_trainer');
            }
            if (count($labels) > 0) {
                sort($labels);

                return implode(' / ', $labels);
            }

            return __('roles.staff');
        }

        return '';
    }

    public function canDo($permission)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->isStaff()) {
            $permissions = [];

            $permissions[] = 'view_admin_menu';
            $permissions[] = 'view_statistics';

            if ($this->hasRole('admin')) {
                $permissions[] = 'create_sections';
                $permissions[] = 'create_staff';
                $permissions[] = 'create_students';
            }

            return in_array($permission, $permissions);
        }

        return false;
    }

    // Profil
    public function profiles()
    {
        return $this->hasMany(Profile::class)->orderBy('updated_at', 'DESC');
    }

    public function hasProfiles()
    {
        return $this->profiles->count() > 0;
    }

    public function hasActiveProfile()
    {
        return ! is_null($this->profiles()->where('in_progress', true)->first());
    }

    public function latestActiveProfile()
    {
        return $this->profiles()->where('in_progress', true)->first();
    }

    public function hasNonCompleteProfile()
    {
        return ! is_null($this->profiles()->where('in_progress', false)->where('completed', false)->first());
    }

    public function latestNonCompleteProfile()
    {
        return $this->profiles()->where('in_progress', false)->where('completed', false)->first();
    }

    public function firstProfile()
    {
        return $this->profiles()->orderBy('date', 'ASC')->first();
    }

    public function latestProfile()
    {
        return $this->profiles()->first();
    }

    public function latestProfiles($count = 5, $offset = 0)
    {
        return $this->profiles()
            ->take($count)
            ->skip($offset)
            ->get();
    }

    public function isCompleted()
    {
        return $this->profiles()->first()->completed ?? false;
    }

    public function isInProgress()
    {
        return $this->profiles()->first()->in_progress;
    }

    //TODO: Can this be deleted?
    public function students()
    {
        return [];
    }

    public function isStaffOf($user)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->isStaff()) {
            if ($user->isStaff()) {
                if ($user->unit_id == $this->unit_id) {
                    return true;
                }
            } else {
                if (! is_null($user->section) && $user->section->unit_id == $this->unit_id) {
                    return true;
                }
            }
        }

        return false;
    }
}
