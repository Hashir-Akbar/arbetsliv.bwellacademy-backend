<?php

use App\FeedbackQuestion;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        $questions[] = FeedbackQuestion::create([
            'name' => 'feedback-meaningful',
            'text' => 'Bwellmetoden känns meningsfull',
        ]);

        $questions[] = FeedbackQuestion::create([
            'name' => 'feedback-responsibility',
            'text' => 'Bwellmetoden gör att jag tar större ansvar för min hälsa/livsstil',
        ]);

        $questions[]  = FeedbackQuestion::create([
            'name' => 'feedback-stimulating',
            'text' => 'Bwellmetoden stimulerar gemenskap och samarbete',
        ]);

        foreach ($questions as $question) {
            $question->options()->create([ 'text' => 'Håller helt med', 'value' => '1', ]);
            $question->options()->create([ 'text' => 'Håller delvis med', 'value' => '0', ]);
            $question->options()->create([ 'text' => 'Håller inte med', 'value' => '-1', ]);
        }
    }

    public function down(): void
    {
        FeedbackQuestion::where('name', 'feedback-stimulating')->delete();
        FeedbackQuestion::where('name', 'feedback-responsibility')->delete();
        FeedbackQuestion::where('name', 'feedback-meaningful')->delete();
    }
};
