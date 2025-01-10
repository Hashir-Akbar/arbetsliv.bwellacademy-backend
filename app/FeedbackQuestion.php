<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedbackQuestion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'text',
    ];

    public function options(): HasMany {
        return $this->hasMany(FeedbackOption::class);
    }
}
