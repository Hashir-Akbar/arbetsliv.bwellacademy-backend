<?php

namespace App\Http\Requests;

use App\FeedbackQuestion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Validator;

/**
 * @property array<string,string> $answers
 * @property string $profile Profile id as a string
 */
class CreateFeedbackRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $feedbackQuestions = $this->getActiveFeedbackQuestionsAndValidOptions();

            foreach ($this->input('answers') as $name => $value) {
                // Ensure active question with name exists
                if (!$feedbackQuestions->has($name)) {
                    $validator->errors()->add($name, "Invalid feedback question '$name'!");
                    continue;
                }

                // Ensure provided answer is valid for this question
                if (!$feedbackQuestions[$name]->contains($value)) {
                    $validator->errors()->add($name, "Invalid option '$value' for feedback question '$name'!");
                }
            }
        });
    }

    public function authorize(): bool
    {
        if (!$this->user()->hasActiveProfile()) {
            return false;
        }

        $lastActiveProfile = $this->user()->latestActiveProfile();

        return (int)$this->route('profile') === $lastActiveProfile->id &&
            $lastActiveProfile->feedbackAnswers()->count() === 0;
    }

    function getActiveFeedbackQuestionsAndValidOptions(): Collection
    {
        return FeedbackQuestion::with('options')
            ->get()
            ->mapWithKeys(function (FeedbackQuestion $q) {
                return [
                    $q->name => $q->options->pluck('value')
                ];
            });
    }
}
