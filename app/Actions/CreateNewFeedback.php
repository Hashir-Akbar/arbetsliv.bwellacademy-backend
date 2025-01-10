<?php

namespace App\Actions;

use App\FeedbackAnswer;
use App\Http\Requests\CreateFeedbackRequest;

class CreateNewFeedback
{
    public function handle(CreateFeedbackRequest $request): void
    {
        $profileId = (int)$request->profile;

        collect($request->answers)->each(function($value, $question) use($profileId) {
            FeedbackAnswer::create([
                'profile_id' => $profileId,
                'name' => $question,
                'value' => $value,
            ]);
        });
    }
}
