<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Profile;
use App\Services\ProfilesService;
use App\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request, ProfilesService $profilesService): array
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        /** @var User|null $user */
        $user = User::where('email', $request->email)->first();

        abort_if(
            ! $user || ! Hash::check($request->password, $user->password),
            403,
            'Invalid credentials'
        );

        $token = $user->createToken(Hash::make($user->email . now()->format('Ymd-His')))->plainTextToken;

        $unitName = $user->unit?->name ?? $user->section?->unit?->name ?? 'Bwell';

        $userData = collect($user)
            ->only([
                'id',
                'first_name',
                'last_name',
                'email',
                'sex',
            ])
            ->put('company', $unitName)
            ->put('active_profile', $profilesService->activeProfile($user))
            ->put('finished_profiles', $profilesService->finishedProfiles($user))
            ->put('has_profiles', $user->profiles()->count() > 0);

        return [
            'user' => $userData,
            'token' => $token,
        ];
    }

    public function user(Request $request)
    {
        return $request->user();
    }
}
