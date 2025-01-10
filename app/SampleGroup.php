<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SampleGroup extends Model
{
    protected $table = 'sample_groups';

    public $timestamps = false;

    protected static function booted()
    {
        static::deleting(function ($group) {
            // delete members
            SampleGroupMember::where('sample_group_id', $group->id)->delete();
        });
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'sample_members');
    }
}
