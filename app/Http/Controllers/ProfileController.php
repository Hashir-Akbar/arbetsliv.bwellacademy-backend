<?php

namespace App\Http\Controllers;

use App\Country;
use App\County;
use App\Profile;
use App\ProfileFactor;
use App\ProfileValue;
use App\QuestionnaireCategory;
use App\QuestionnairePage;
use App\QuestionnaireQuestion;
use App\Section;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('student')->only(['getList', 'getProfileMock', 'getProfileSelf']);
    }

    public function getList(Request $request)
    {
        $user = $request->user();

        $profiles = $user->profiles()
            ->orderBy('date', 'desc')
            ->get();

        $data = [
            'user' => $user,
            'profiles' => $profiles,
        ];

        return view('questionnaire.profiles', $data);
    }

    public function getProfileMock(Request $request, $page_id = 1)
    {
        $user = $request->user();

        $page = QuestionnairePage::findOrFail($page_id);

        $min = 1;
        $max = QuestionnairePage::count();

        $nextIdx = $page->id >= $max ? $min : ($page->id + 1);
        $prevIdx = $page->id - 1 < $min ? $max : $page->id - 1;

        $profile_id = config('fms.mock_profile');
        if (is_null($profile_id)) {
            abort(404);
        }

        $profile = Profile::findOrFail($profile_id);

        $factors = [];
        foreach ($profile->factors as $factor) {
            $factors[$factor->category_id] = $factor;
        }

        $values = [];
        foreach ($profile->values as $value) {
            $values[$value->name] = $value->value;
        }

        $data = [
            'profile' => $profile,
            'user' => $user,
            'participant' => $user,
            'isUsersProfile' => true,
            'editable' => false,
            'mock' => true,
            'page' => $page,
            'prev' => $prevIdx,
            'next' => $nextIdx,
            'factors' => $factors,
            'values' => $values,
            'firstPage' => ($page_id == $min),
            'lastPage' => ($page_id == $max),
            'inProgress' => true,
            'active' => 'test-profile',
            'activePage' => $page->name,
            'help' => 'profile',
            'cssClasses' => 'questionnaire-page',
        ];

        return view('questionnaire.base', $data);
    }

    public function getProfileSelf(Request $request, $page_id = 1)
    {
        $user = $request->user();

        $profile = $this->getSelfProfile($user);
        if (is_null($profile)) {
            abort(404);
        }

        return redirect(action('ProfileController@getProfile', ['id' => $profile->id, 'page_id' => $page_id]));
    }

    public function getProfile(Request $request, $id, $page_id = 1)
    {
        $user = $request->user();

        $profile = Profile::findOrFail($id);

        $isUsersProfile = ($profile->user_id == $user->id);

        if ($isUsersProfile) {
            if (! isset($user->sex) || $user->sex == 'U') {
                return redirect(url('/setsex'));
            }

            if (! isset($user->accepted)) {
                return redirect(url('/terms'));
            }
        } else {
            if (! $profile->canSeeEverything($user)) {
                abort(403);
            }
        }

        $page = QuestionnairePage::findOrFail($page_id);

        $min = 1;
        $max = QuestionnairePage::count();

        $nextIdx = $page->id >= $max ? $min : ($page->id + 1);
        $prevIdx = $page->id - 1 < $min ? $max : $page->id - 1;

        $factors = [];
        foreach ($profile->factors as $factor) {
            $factors[$factor->category_id] = $factor;
        }

        $values = [];
        foreach ($profile->values as $value) {
            $values[$value->name] = $value->value;
        }

        $data = [
            'profile' => $profile,
            'user' => $user,
            'participant' => $user,
            'isUsersProfile' => $isUsersProfile,
            'editable' => $isUsersProfile && $profile->in_progress && ! $profile->completed,
            'mock' => false,
            'page' => $page,
            'prev' => $prevIdx,
            'next' => $nextIdx,
            'factors' => $factors,
            'values' => $values,
            'firstPage' => ($page_id == $min),
            'lastPage' => ($page_id == $max),
            'active' => 'questionnaire',
            'activePage' => $page->name,
            'help' => 'profile',
            'cssClasses' => 'questionnaire-page',
        ];

        return view('questionnaire.base', $data);
    }

    public function postValue(Request $request, $id)
    {
        $user = $request->user();
        $profile = Profile::findOrFail($id);

        if ($profile->user_id !== $user->id) {
            abort(403);
        }

        $data = $request->all();

        $this->parseValueArray($data['values'] ?? $data, $id);

        $profile->calculate();

        $category_id = null;

        if (isset($data['name'])) {
            if (Str::startsWith($data['name'], 'fit')) {
                $category = QuestionnaireCategory::where('name', 'fitness')->first();
                if ($category) {
                    $category_id = $category->id;
                }
            } elseif (in_array($data['name'], ['armMethod', 'strArmWeights', 'pushupsType'])) {
                $category = QuestionnaireCategory::where('name', 'strArms')->first();
                if ($category) {
                    $category_id = $category->id;
                }
            } elseif (Str::startsWith($data['name'], 'energyIntake')) {
                $category = QuestionnaireCategory::where('name', 'foodEnergyBalance')->first();
                if ($category) {
                    $category_id = $category->id;
                }
            } else {
                $question = QuestionnaireQuestion::where('form_name', $data['name'])->first();
                if ($question) {
                    $category_id = $question->category_id;
                }
            }
        }

        if ($category_id) {
            $factor = ProfileFactor::where('category_id', $category_id)->where('profile_id', $profile->id)->first();
            if ($factor) {
                $data['risk_value'] = $factor->value;
                $data['risk_status_label'] = t($factor->status);
                $data['risk_status_name'] = $factor->status;
                $data['category_id'] = $category_id;

                //Todo: Translate properly
                $show_improve = $factor->status != 'profile.unknown';
                if ($show_improve) {
                    $statusClass = 'status-' . ($factor->status == 'profile.risk' ? 'risk' : 'healthy');
                    if (App::isLocale('sv')) {
                        $data['status_text'] = 'Du har värde <span class="' . $statusClass . '">' . $factor->value . '</span> - ' . t($factor->status);
                    } else {
                        $data['status_text'] = 'Your value is  <span class="' . $statusClass . '">' . $factor->value . '</span> - ' . t($factor->status);
                    }
                } else {
                    if (App::isLocale('sv')) {
                        $data['status_text'] = 'Du har inget värde än';
                    } else {
                        $data['status_text'] = 'You don\'t have a value yet';
                    }
                }

                $fitness_category = QuestionnaireCategory::where('name', 'fitness')->first();
                if ($category_id == $fitness_category->id) {
                    $weight = $profile->getValue('weight');
                    if (empty($weight)) {
                        $data['fitness_text'] = 'Du måste ange vikt först';
                        $data['status_text'] = '';
                    } else {
                        if ($show_improve) {
                            $fitO2min = $profile->getValue('fitO2min');
                            $fitO2kg = $profile->getValue('fitO2kg');
                            $data['fitness_text'] = $fitO2min . ' L/min, ' . $fitO2kg . ' ml/kg/min';
                        } else {
                            $data['fitness_text'] = '';
                        }
                    }
                }

                $energy_balance_category = QuestionnaireCategory::where('name', 'foodEnergyBalance')->first();
                if ($category_id == $energy_balance_category->id) {
                    $data['energy_intake_value'] = $profile->getValue('foodEnergyIntake') ?? 0;
                    $data['energy_balance_value'] = $profile->getValue('foodEnergyBalance') ?? 0;
                }
            } else {
                $data['error'] = 'missing factor';
            }
        } else {
            $data['error'] = 'missing category';
        }

        return $data;
    }

    public function postFinish(Request $request, $id)
    {
        $user = $request->user();
        $profile = Profile::findOrFail($id);

        if ($profile->user_id !== $user->id) {
            abort(403);
        }

        $profile->in_progress = false;

        $profile->save();

        $profile->calculate();

        return redirect(action('StatementController@getSatisfied', ['id' => $profile->id]));
    }

    public function postUnlock(Request $request, $id)
    {
        $user = $request->user();
        $profile = Profile::findOrFail($id);

        if (!($user->isSuperAdmin() || $user->isAdmin()) && $profile->user_id !== $user->id) {
            abort(403);
        }

        $profile->in_progress = true;
        $profile->completed = false;

        $profile->save();

        return redirect(action('ProfileController@getProfile', ['id' => $profile->id, 'page_id' => 1]));
    }

    private function getSelfProfile($user)
    {
        $latestProfile = $user->latestProfile();
        if (! is_null($latestProfile) && ($latestProfile->isActive() || ! $latestProfile->isComplete())) {
            return $latestProfile;
        }

        $section = $user->section;
        $school = $user->section->unit;
        $schoolType = $school->school_type === 'unit.primary' ? 'primary' : 'secondary';
        $county = $school->county;
        $country = $county->country;

        $data = [
            'date' => date('Y-m-d'),
            'data' => [
                'country' => $country->id,
                'county' => $county->id,
                'schooltype' => $schoolType,
                'school' => $school->id,
                'class' => $section->id,
            ],
        ];

        return $this->createProfile($user->id, $data);
    }

    private function createProfile($userId, $input)
    {
        $profile = new Profile;

        $profile->user_id = $userId;
        $profile->date = $input['date'];
        $profile->health_count = 0;
        $profile->risk_count = 0;
        $profile->unknown_count = 0;
        $profile->notes = '';
        $profile->in_progress = true;

        $profile->save();

        $profile->createFactors();

        $profile->values = [];

        return $profile;
    }

    private function parseValueArray($data, $id)
    {
        if (isset($data['name'])) {
            $profVal = ProfileValue::where('name', $data['name'])
                ->where('profile_id', $id)->first();

            if (is_null($profVal)) {
                $profVal = new ProfileValue;
                $profVal->name = $data['name'];
                $profVal->profile_id = $id;
            }

            $profVal->value = is_numeric($data['value']) ? $data['value'] : null;
            $profVal->save();
        } else {
            foreach ($data as $entry) {
                $this->parseValueArray($entry, $id);
            }
        }
    }

    // Todo: Unused - Remove this?
    private function resolveValue($key, $value)
    {
        if ($key === 'country') {
            $c = Country::find($value);

            return $c->label;
        } elseif ($key === 'county') {
            $c = County::find($value);

            return $c->label;
        } elseif ($key === 'schooltype') {
            if ($value === 'primary') {
                return 'unit.primary';
            } elseif ($value === 'secondary') {
                return 'unit.secondary';
            }
        } elseif ($key === 'school') {
            $c = Unit::find($value);

            return $c->name;
        } elseif ($key === 'class') {
            $c = Section::find($value);

            return $c->name;
        }
    }
}
