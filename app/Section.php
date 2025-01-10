<?php

namespace App;

use App;
use Cache;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public $timestamps = true;

    protected $fillable = ['archived_at'];

    protected static function booted()
    {
        static::deleting(function ($section) {
            // delete students
            foreach (User::where('section_id', $section->id)->get() as $user) {
                $user->delete();
            }
        });
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit', 'unit_id');
    }

    public function program()
    {
        return $this->belongsTo('App\SecondaryProgram', 'program_id');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function full_name()
    {
        $programs = Cache::remember('secondary_programs', 30, function () {
            $programs = [];
            foreach (SecondaryProgram::all() as $program) {
                $programs[$program->id] = $program;
            }

            return $programs;
        });

        $str = $this->name;
        if (config('fms.type') == 'school') {
            if (! is_null($this->program_id) && isset($programs[$this->program_id])) {
                $str .= ' ' . $programs[$this->program_id]->label;
            }

            if ($this->school_year > 0) {
                if (App::isLocale('en')) {
                    $str .= ' grade ';
                } else {
                    $str .= ' årskurs ';
                }
                $str .= $this->school_year;
            }
        }

        return $str;
    }

    public function accessibleBy($user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isStaff()) {
            if ($user->unit_id == $this->unit_id) {
                return true;
            }
        }

        return false;
    }
}
