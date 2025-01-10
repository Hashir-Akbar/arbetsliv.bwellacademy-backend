<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireCategory extends Model
{
    protected $table = 'questionnaire_categories';

    public $timestamps = false;

    protected $fillable = [
        'label',
        'name',
        'show_bar',
        'health',
        'page_name',
    ];
}
