<?php

namespace App\Nobox\Calculation;

use App\Profile;
use App\QuestionnaireCategory;
use Illuminate\Support\Facades\DB;

abstract class ProfileType
{
    const METHOD_STEPTEST = 0;

    const METHOD_BICYCLE = 1;

    const METHOD_MLO2 = 2;

    const METHOD_LO2 = 3;

    const METHOD_FLEX = 4;

    const METHOD_WALK = 5;

    const METHOD_BEEP = 6;

    const METHOD_COOPER = 7;

    protected $profile;

    protected $age;

    protected $sex;

    private $factors;

    private $profileFactors;

    private $updatedProfileFactors;

    private $profileValues;

    private $updatedProfileValues;

    abstract public function calculate(Profile $profile);

    protected function init(Profile $profile)
    {
        $this->profile = $profile;

        if (is_null($this->profile->user)) {
            throw new \Exception('User not found');
        }

        $this->age = $this->profile->userAge();
        $this->sex = $this->profile->user->sex;

        // factor name to ID mappings
        $categories = QuestionnaireCategory::all();
        foreach ($categories as $category) {
            $this->factors[$category->name] = $category->id;
        }

        // fetch profile factors
        $this->profileFactors = [];
        foreach ($this->profile->factors as $factor) {
            $this->profileFactors[$factor->category_id] = ['value' => $factor->value, 'status' => $factor->status];
        }
        $this->updatedProfileFactors = [];

        // fetch profile values
        $this->profileValues = [];
        foreach ($this->profile->values as $value) {
            $this->profileValues[$value->name] = $value->value;
        }
        $this->updatedProfileValues = [];
    }

    protected function commit()
    {
        DB::transaction(function () {
            // update factors
            foreach ($this->updatedProfileFactors as $k => $v) {
                DB::table('profile_factors')
                    ->updateOrInsert(
                        ['profile_id' => $this->profile->id, 'category_id' => $k],
                        ['value' => $v['value'], 'status' => $v['status']]
                    );
            }

            // update values
            foreach ($this->updatedProfileValues as $k => $v) {
                DB::table('profile_values')
                    ->updateOrInsert(
                        ['profile_id' => $this->profile->id, 'name' => $k],
                        ['value' => $v]
                    );
            }
        });
    }

    protected function getFactor($name)
    {
        if (! isset($this->factors[$name])) {
            throw new \Exception('Unknown factor: ' . $name);
        }
        $factor_id = $this->factors[$name];

        if (array_key_exists($factor_id, $this->updatedProfileFactors)) {
            return $this->updatedProfileFactors[$factor_id];
        }

        if (array_key_exists($factor_id, $this->profileFactors)) {
            return $this->profileFactors[$factor_id];
        }

        return null;
    }

    protected function setFactor($name, $value, $status)
    {
        if (! isset($this->factors[$name])) {
            throw new \Exception('Unknown factor: ' . $name);
        }
        $factor_id = $this->factors[$name];

        $this->updatedProfileFactors[$factor_id] = ['value' => $value, 'status' => $status];
    }

    protected function getValue($name)
    {
        if (array_key_exists($name, $this->updatedProfileValues)) {
            return $this->updatedProfileValues[$name];
        }

        if (array_key_exists($name, $this->profileValues)) {
            return $this->profileValues[$name];
        }

        return null;
    }

    protected function setValue($name, $value)
    {
        $this->updatedProfileValues[$name] = $value;
    }

    protected function singleValue($factorName, $valueName, $riskLevel = 3)
    {
        $value = $this->getValue($valueName);

        if (! is_numeric($value)) {
            $this->setFactor($factorName, null, 'profile.unknown');

            return;
        }

        if ($value < $riskLevel) {
            $this->setFactor($factorName, $value, 'profile.risk');
        } else {
            $this->setFactor($factorName, $value, 'profile.healthy');
        }
    }

    protected function multiValueAvg($factorName, $valueNames, $riskLevel = 3)
    {
        $sum = 0;

        foreach ($valueNames as $valueName) {
            $value = $this->getValue($valueName);

            if (! is_numeric($value)) {
                $this->setFactor($factorName, null, 'profile.unknown');

                return;
            }

            $sum += $value;
        }

        $avgValue = round($sum / count($valueNames));

        if ($avgValue < $riskLevel) {
            $this->setFactor($factorName, $avgValue, 'profile.risk');
        } else {
            $this->setFactor($factorName, $avgValue, 'profile.healthy');
        }
    }

    protected function multiValueMin($factorName, $valueNames, $riskLevel = 3)
    {
        $minValue = null;

        foreach ($valueNames as $valueName) {
            $value = $this->getValue($valueName);

            if (! is_numeric($value)) {
                $this->setFactor($factorName, null, 'profile.unknown');

                return;
            }

            if (is_null($minValue)) {
                $minValue = $value;
            } else {
                $minValue = min($minValue, $value);
            }
        }

        if ($minValue < $riskLevel) {
            $this->setFactor($factorName, $minValue, 'profile.risk');
        } else {
            $this->setFactor($factorName, $minValue, 'profile.healthy');
        }
    }
}
