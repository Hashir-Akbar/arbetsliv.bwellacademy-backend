<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileValue extends Model
{
    protected $table = 'profile_values';

    public $timestamps = false;

    protected $fillable = ['name', 'value'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
