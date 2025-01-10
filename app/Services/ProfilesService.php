<?php

namespace App\Services;

use App\Profile;
use App\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class ProfilesService
{
    public function activeProfile(User $user): Profile | null
    {
        $activeProfile = $user->profiles()
            ->where('in_progress', true)
            ->with('values', 'factors')
            ->first();

        if(is_null($activeProfile)) {
            return null;
        }

        return $this->transformProfile($activeProfile);
    }

    public function finishedProfiles(User $user): Collection
    {
        $finishedProfiles = $user->profiles()
            ->where('in_progress', false)
            ->orderByDesc('created_at')
            ->get(['id','created_at']);

        return $this->transformFinishedProfiles($finishedProfiles);
    }

    public function profileWithId(User $user, int $profileId): Profile | null
    {
        $profile = $user->profiles()
            ->where('id', $profileId)
            ->with('values', 'factors')
            ->first();

        if(is_null($profile)) {
            return null;
        }

        return $this->transformProfile($profile);
    }

    private function transformProfile(Profile $profile): Profile
    {
        $values = [];
        foreach ($profile->values as $kv) {
            $values[$kv->name] = (string) $kv->value;
        }
        unset($profile->values);
        $profile->values = $values;

        $factors = [];
        foreach ($profile->factors as $factor) {
            $factors[$factor->category_id] = [
                'status' => $factor->status,
                'label' => t($factor->status),
                'improve' => (string) $factor->improve,
                'value' => (string) $factor->value,
                'risk_value' => (string) $factor->value,
            ];
        }
        unset($profile->factors);
        $profile->factors = $factors;

        return $profile;
    }

    private function transformFinishedProfiles(EloquentCollection $profiles): Collection
    {
        return $profiles->map(function(Profile $profile) {
            return [
                'id' => $profile->id,
                'created_at' => $profile->created_at->toIso8601ZuluString(),
            ];
        });
    }
}
