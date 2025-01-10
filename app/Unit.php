<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unit extends Model
{
    protected $table = 'unit';

    public $timestamps = true;

    protected static function booted()
    {
        static::deleting(function ($unit) {
            // delete staff
            foreach (User::where('unit_id', $unit->id)->get() as $staff) {
                $staff->delete();
            }

            // delete sections
            foreach (Section::where('unit_id', $unit->id)->get() as $section) {
                $section->delete();
            }

            // delete sample groups
            foreach (SampleGroup::where('unit_id', $unit->id)->get() as $group) {
                $group->delete();
            }
        });
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'county_id');
    }

    public function business_category(): BelongsTo
    {
        return $this->belongsTo(BusinessCategory::class);
    }

    public function country()
    {
        return $this->county->country();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function countyLabel()
    {
        if ($this->county_id) {
            return __($this->county->label);
        }

        return '';
    }

    public function countryLabel()
    {
        if ($this->county_id) {
            return __($this->county->country->label);
        }

        return '';
    }

    public function schoolType()
    {
        $value = -1;

        switch ($this->school_type) {
            default:
            case 'unit.none':
                $value = -1;
                break;
            case 'unit.primary':
                $value = 1;
                break;
            case 'unit.secondary':
                $value = 2;
                break;
        }

        return $value;
    }

    public function accessibleBy($user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isStaff()) {
            if ($user->unit_id == $this->id) {
                return true;
            }
        }

        return false;
    }
}
