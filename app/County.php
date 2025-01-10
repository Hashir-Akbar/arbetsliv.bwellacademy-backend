<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
