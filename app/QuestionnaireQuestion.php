<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class QuestionnaireQuestion extends Model
{
    protected $table = 'questionnaire_questions';

    public $timestamps = false;

    protected $fillable = [
        'group_id',
        'category_id',
        'form_name',
        'type_id',
        'data',
        'label_sv',
        'description_sv',
        'has_help',
        'weight'
    ];

    public function scopeWeighted($query)
    {
        return $query->orderBy('weight', 'ASC');
    }

    public function group()
    {
        return $this->belongsTo(QuestionnaireGroup::class, 'group_id');
    }

    public function type()
    {
        return $this->belongsTo(ElementType::class, 'type_id');
    }

    public function category()
    {
        return $this->belongsTo(QuestionnaireCategory::class, 'category_id');
    }

    public function t_label()
    {
        if (App::isLocale('en') && ! empty($this->label_en)) {
            return $this->label_en;
        }

        return $this->label_sv;
    }

    public function t_description()
    {
        if (App::isLocale('en') && ! empty($this->description_en)) {
            return $this->description_en;
        }

        return $this->description_sv;
    }

    public function t_poster()
    {
        if (App::isLocale('en') && ! empty($this->poster_en_url)) {
            return $this->poster_en_url;
        }

        return $this->poster_sv_url;
    }

    public function t_poster_text()
    {
        if (App::isLocale('en') && ! empty($this->poster_en_text)) {
            return $this->poster_en_text;
        }

        return $this->poster_sv_text;
    }

    public function t_help()
    {
        if (App::isLocale('en') && ! empty($this->help_en)) {
            return $this->help_en;
        }

        return $this->help_sv;
    }
}
