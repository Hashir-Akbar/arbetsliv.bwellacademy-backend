<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\QuestionnairePage;
use App\Services\QuestionsService;
use Illuminate\Support\Str;

class QuestionsController extends Controller
{
    public function workQuestions(QuestionsService $questionsService)
    {
        if (config('fms.type') !== 'work') {
            abort(404);
        }

        return $questionsService->workQuestions();
    }

    public function schoolQuestions(QuestionsService $questionsService)
    {
        if (config('fms.type') !== 'school') {
            abort(404);
        }

        return $questionsService->schoolQuestions();
    }

    public function lifeQuestions(QuestionsService $questionsService)
    {
        return $questionsService->lifeQuestions();
    }
}
