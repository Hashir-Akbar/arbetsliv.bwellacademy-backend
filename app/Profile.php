<?php

namespace App;

use App\Nobox\Calculation\StudentProfileType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    public $timestamps = true;

    protected $attributes = [];

    protected $appends = ['o2kg', 'o2lmin', 'hasValidBorg', 'fitnessMethod'];

    public $fillable = [
        'user_id',
        'date',
        'health_count',
        'risk_count',
        'unknown_count',
        'notes',
        'in_progress',
    ];

    public function getO2kgAttribute()
    {
        return $this->getValue('fitO2kg');
    }

    public function getO2lminAttribute()
    {
        return $this->getValue('fitO2min');
    }

    public function getHasValidBorgAttribute()
    {
        return intval($this->getValue('fitBorg')) > 11;
    }

    public function getFitnessMethodAttribute()
    {
        return intval($this->getValue('fitMethod'));
    }

    public function isActive()
    {
        return $this->in_progress;
    }

    public function isComplete()
    {
        return $this->completed;
    }

    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }

    public function getDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->toDateString();
    }

    public function calculate()
    {
        $calculator = new StudentProfileType;

        $calculator->calculate($this);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function userAge()
    {
        $date = \Carbon\Carbon::parse($this->date);

        $user = $this->user;
        if (is_null($user)) {
            $user = User::find($this->user_id);
        }
        if (is_null($user)) {
            return 0;
        }

        $diff = $date->diffInYears($user->birth_date);

        return $diff;
    }

    public function values()
    {
        return $this->hasMany(ProfileValue::class, 'profile_id');
    }

    public function hasValue($name)
    {
        $value = $this->values()->where('name', $name)->first();

        return ! is_null($value) && $value->value > 0;
    }

    public function getValueByName($name, $default = null)
    {
        $value = $this->values()->where('name', $name)->first();

        if (! is_null($value)) {
            return $value;
        }

        return $default;
    }

    public function getValue($name, $default = null)
    {
        $value = $this->values()->where('name', $name)->first();

        if (! is_null($value)) {
            return $value->value;
        }

        return $default;
    }

    public function getValueStatus($name)
    {
        $status = $this->values()->where('name', $name)->first();

        if (is_null($status)) {
            return 'profile.unknown';
        }

        return $status->status;
    }

    public function setValue($name, $value, $status = null)
    {
        $profval = $this->values()->where('name', $name)->first();

        if (is_null($profval)) {
            $profval = new ProfileValue;
            $profval->name = $name;
            $profval->profile_id = $this->id;
        }

        $profval->value = $value;

        if (! is_null($status)) {
            $profval->status = $status;
        }

        $profval->save();
    }

    public function removeValue($name)
    {
        $profval = $this->values()->where('name', '=', $name)->first();

        if (is_null($profval)) {
            return;
        }

        $profval->delete();
    }

    public function factors()
    {
        return $this->hasMany(ProfileFactor::class);
    }

    public function hasFactors()
    {
        return $this->factors()->count() > 0;
    }

    public function getFactor($id)
    {
        $factor = ProfileFactor::where('profile_id', $this->id)
            ->where('category_id', $id)->first();

        return $factor;
    }

    public function getFactorByName($name)
    {
        $category = QuestionnaireCategory::where('name', $name)->first();
        if (is_null($category)) {
            return null;
        }

        return ProfileFactor::where('profile_id', $this->id)
            ->where('category_id', $category->id)->first();
    }

    public function getFactorStatus($name)
    {
        $category = QuestionnaireCategory::where('name', $name)->first();
        if (is_null($category)) {
            return 'profile.unknown';
        }
        $factor = ProfileFactor::where('profile_id', $this->id)
            ->where('category_id', $category->id)->first();

        return $factor->status;
    }

    public function getFactorStatusAsFlag($name)
    {
        $status = $this->getFactorStatus($name);

        switch ($status) {
            case 'profile.risk':
                return 1;
            case 'profile.healthy':
                return 2;
            case 'profile.unknown':
                return 4;
        }
    }

    public function setFactor($id, $value, $status)
    {
        $factor = ProfileFactor::where('profile_id', $this->id)
            ->where('category_id', $id)->first();

        if (is_null($factor)) {
            $factor = new ProfileFactor;
            $factor->profile_id = $this->id;
            $factor->category_id = $id;
        }

        $factor->value = $value;
        $factor->status = $status;

        $factor->save();
    }

    public function countHealthy()
    {
        return $this->factors()->where('status', 'profile.healthy')->count();
    }

    public function countRisks()
    {
        return $this->factors()->where('status', 'profile.risk')->count();
    }

    public function texts()
    {
        return $this->hasMany(ProfileText::class);
    }

    public function createFactors()
    {
        $factors = QuestionnaireCategory::all();

        foreach ($factors as $factor) {
            $pf = new ProfileFactor;

            $pf->profile_id = $this->id;
            $pf->category_id = $factor->id;

            $pf->save();
        }
    }

    public function accessibleBy($user)
    {
        if ($user->id === $this->user_id) {
            return true;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($user->isStaffOf($this->user)) {
            if ($user->isNurse()) {
                return true;
            }
        }

        return false;
    }

    public function canSeeEverything($user)
    {
        if ($user->id === $this->user_id) {
            return true;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->accessibleBy($user)) {
            if ($user->isNurse() || $user->isPhysicalTrainer()) {
                return true;
            }
        }

        return false;
    }

    public function feedbackAnswers(): HasMany {
        return $this->hasMany(FeedbackAnswer::class);
    }
}
