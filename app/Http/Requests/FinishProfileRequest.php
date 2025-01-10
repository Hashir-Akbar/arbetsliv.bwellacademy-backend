<?php

namespace App\Http\Requests;

use App\Profile;
use Illuminate\Foundation\Http\FormRequest;

class FinishProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasActiveProfile();
    }

    public function profile(): ?Profile
    {
        return $this->user()->latestActiveProfile();
    }
}
