<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class QuestionnaireGroup extends Model
{
    protected $table = 'questionnaire_groups';

    public $timestamps = false;

    public function scopeWeighted($query)
    {
        return $query->orderBy('weight', 'ASC');
    }

    public function questions()
    {
        return $this->hasMany(QuestionnaireQuestion::class, 'group_id')->orderBy('weight', 'ASC');
    }

    public function type()
    {
        return $this->belongsTo(GroupType::class, 'type_id');
    }

    public function page()
    {
        return $this->belongsTo(QuestionnairePage::class, 'page_id');
    }

    public function t_label()
    {
        if (App::isLocale('en') && ! empty($this->label_en)) {
            return $this->label_en;
        }

        return $this->label_sv;
    }
}
