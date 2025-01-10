<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedbackAnswer extends Model
{
    protected $fillable = [
        'profile_id',
        'name',
        'value',
    ];

    public function profile(): BelongsTo {
        return $this->belongsTo(Profile::class);
    }
}
