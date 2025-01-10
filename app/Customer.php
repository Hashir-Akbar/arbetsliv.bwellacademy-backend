<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    public $timestamps = true;

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function hasUnits()
    {
        return $this->units->count() > 0;
    }

    public function hasSchool()
    {
        if (! $this->hasUnits()) {
            return false;
        }

        return $this->units->first()->type == 'unit.school';
    }
}
