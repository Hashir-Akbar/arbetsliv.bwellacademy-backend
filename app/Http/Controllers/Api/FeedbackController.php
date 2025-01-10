<?php

namespace App\Http\Controllers\Api;

use App\Actions\CreateNewFeedback;
use App\FeedbackOption;
use App\FeedbackQuestion;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFeedbackRequest;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    public function index()
    {
        return FeedbackQuestion::with([
            'options' => fn (Builder $q) => $q->orderBy('id'),
        ])
            ->orderBy('id')
            ->get()
            ->map(function (FeedbackQuestion $question) {
                return [
                    ...$question->only('name', 'text'),
                    'options' => $question->options->map(function (FeedbackOption $option) {
                        return $option->only('text', 'value');
                    })
                ];
            });
    }

    public function store(CreateFeedbackRequest $request, CreateNewFeedback $createNewFeedback)
    {
        DB::transaction(fn() => $createNewFeedback->handle($request));

        return response()->json([
            'status' => 'success',
        ], 201);
    }
}
