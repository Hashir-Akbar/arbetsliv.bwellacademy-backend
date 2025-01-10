<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitStaff extends Model
{
    protected $table = 'unit_staff';

    public $timestamps = false;

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
