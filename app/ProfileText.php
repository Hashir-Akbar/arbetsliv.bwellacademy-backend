<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileText extends Model
{
    protected $table = 'profile_texts';

    public $timestamps = false;

    protected $fillable = [
        'profile_id',
        'name',
        'content',
    ];
}
