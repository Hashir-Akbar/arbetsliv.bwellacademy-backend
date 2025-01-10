<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatsFilter extends Model
{
    protected $table = 'stats_filters';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
