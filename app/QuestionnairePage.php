<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class QuestionnairePage extends Model
{
    protected $table = 'questionnaire_page';

    public $timestamps = false;

    public function groups()
    {
        return $this->hasMany(QuestionnaireGroup::class, 'page_id')->weighted();
    }

    public function hasGroups()
    {
        return $this->groups()->count() > 0;
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
}
