<?php

namespace App\Actions;

use App\Http\Requests\FinishProfileRequest;

class FinishProfile
{
    public function handle(FinishProfileRequest $request): void
    {
        $profile = $request->profile();

        $profile->update([
            'in_progress' => false,
            'completed' => true
        ]);
        
        $profile->calculate();
    }
}
