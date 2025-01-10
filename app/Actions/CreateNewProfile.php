<?php

namespace App\Actions;

use App\Http\Requests\CreateProfileRequest;
use App\Profile;

class CreateNewProfile
{
    public function handle(CreateProfileRequest $request): Profile
    {
        $profile = Profile::create([
            'user_id' => $request->user()->id,
            'date' => today()->format('Y-m-d'),
            'health_count' => 0,
            'risk_count' => 0,
            'unknown_count' => 0,
            'notes' => '',
            'in_progress' => true,
        ]);

        $profile->createFactors();

        $profile->factors = (object) [];
        $profile->values = (object) [];

        return $profile;
    }
}
