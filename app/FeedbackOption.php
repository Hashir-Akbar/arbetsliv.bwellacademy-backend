<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedbackOption extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'text',
        'value',
    ];

    public function question(): BelongsTo {
        return $this->belongsTo(FeedbackQuestion::class);
    }
}
