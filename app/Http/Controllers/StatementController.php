<?php

namespace App\Http\Controllers;

use App\Profile;
use App\ProfileFactor;
use App\ProfileText;
use App\QuestionnaireCategory;
use App\QuestionnairePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StatementController extends Controller
{
    public function getResultsMock()
    {
        $user = Auth::user();
        if ($user->isStudent()) {
            abort(403);
        }

        $profile_id = config('fms.mock_profile');
        if (is_null($profile_id)) {
            abort(404);
        }

        $profile = Profile::findOrFail($profile_id);

        $mainChartData = $this->getAverage($profile_id);

        $data = [
            'active' => 'test-profile',
            'profile' => $profile,
            'user' => $user,
            'isUsersProfile' => false,
            'editable' => false,
            'mock' => true,
            'mainChartData' => json_encode($mainChartData),
            'canSeeEverything' => true,
        ];

        return view('statement.results', $data);
    }

    public function getResultsSelf(Request $request)
    {
        $user = Auth::user();
        $profile = $user->latestProfile();
        if (is_null($profile)) {
            abort(404);
        }

        return redirect(action('StatementController@getResults', ['id' => $profile->id]));
    }

    public function getResults(Request $request, $id)
    {
        $user = Auth::user();

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
            if (! $profile->accessibleBy($user)) {
                abort(403);
            }
        }

        $profile->calculate();

        $mainChartData = $this->getAverage($id);

        $data = [
            'active' => 'statement-results',
            'profile' => $profile,
            'user' => $user,
            'isUsersProfile' => $isUsersProfile,
            'editable' => $isUsersProfile && $profile->in_progress,
            'mock' => false,
            'mainChartData' => json_encode($mainChartData),
            'canSeeEverything' => true,
        ];

        return view('statement.results', $data);
    }

    public function getSatisfiedMock()
    {
        $user = Auth::user();
        if ($user->isStudent()) {
            abort(403);
        }

        $profile_id = config('fms.mock_profile');
        if (is_null($profile_id)) {
            abort(404);
        }

        $profile = Profile::findOrFail($profile_id);

        $values = [];

        $satProfileText = ProfileText::where('name', 'satProfile')
            ->where('profile_id', $profile->id)
            ->first();

        if (! is_null($satProfileText)) {
            $values['satProfile'] = $satProfileText->content;
        }

        $improve_db = $profile->factors()->where('improve', 1)->get();
        $satisfieds = [];
        foreach ($improve_db as $i) {
            $category = $i->category;
            $satisfieds[] = [
                'label' => t($category->label),
                'category_id' => $category->id,
                'selected' => $i->satisfied,
                'profile_id' => $profile->id,
            ];
        }

        $data = [
            'active' => 'test-profile',
            'profile' => $profile,
            'user' => $user,
            'isUsersProfile' => false,
            'editable' => false,
            'mock' => true,
            'values' => $values,
            'satisfieds' => $satisfieds,
            'canSeeEverything' => true,
        ];

        return view('statement.satisfied', $data);
    }

    public function getSatisfiedSelf(Request $request)
    {
        $user = Auth::user();
        $profile = $user->latestProfile();
        if (is_null($profile)) {
            abort(404);
        }

        return redirect(action('StatementController@getSatisfied', ['id' => $profile->id]));
    }

    public function getSatisfied(Request $request, $id)
    {
        $user = Auth::user();

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
            if (! $profile->accessibleBy($user)) {
                abort(403);
            }
        }

        if ($profile->in_progress) {
            $data = [
                'profile' => $profile,
                'user' => $user,
                'isUsersProfile' => $isUsersProfile,
                'editable' => $isUsersProfile && ! $profile->completed,
                'mock' => false,
                'canSeeEverything' => true,
            ];

            return view('statement.unfinished', $data);
        }

        $values = [];

        $satProfileText = ProfileText::where('name', 'satProfile')
            ->where('profile_id', $profile->id)
            ->first();

        if (! is_null($satProfileText)) {
            $values['satProfile'] = $satProfileText->content;
        }

        $improve_db = $profile->factors()->where('improve', 1)->get();
        $satisfieds = [];
        foreach ($improve_db as $i) {
            $category = $i->category;
            $satisfieds[] = [
                'label' => t($category->label),
                'category_id' => $category->id,
                'selected' => $i->satisfied,
                'profile_id' => $profile->id,
            ];
        }

        $data = [
            // 'active' => "statement-satisfied",
            'active' => 'statement-results',
            'profile' => $profile,
            'user' => $user,
            'isUsersProfile' => $isUsersProfile,
            'editable' => $isUsersProfile && ! $profile->completed,
            'mock' => false,
            'values' => $values,
            'satisfieds' => $satisfieds,
            'canSeeEverything' => true,
        ];

        return view('statement.satisfied', $data);
    }

    public function getGoalsMock()
    {
        $user = Auth::user();
        if ($user->isStudent()) {
            abort(403);
        }

        $profile_id = config('fms.mock_profile');
        if (is_null($profile_id)) {
            abort(404);
        }

        $profile = Profile::findOrFail($profile_id);

        $improve_db_1 = $profile->factors()->where('improve', 1)->get();
        $satisfieds = [];
        foreach ($improve_db_1 as $i) {
            $category = $i->category;
            if ($category) {
                $satisfieds[] = [
                    'label' => t($category->label),
                    'category_id' => $category->id,
                    'selected' => $i->satisfied,
                ];
            }
        }

        $improve_db_2 = $profile->factors()->where('improve', 2)->get();
        $improves = [];
        $targets = [];
        $targetCount = 0;
        foreach ($improve_db_2 as $i) {
            $category = $i->category;
            if ($category) {
                $improve = [
                    'label' => t($category->label),
                    'category_id' => $category->id,
                    'selected' => $i->target,
                    'value' => $i->value,
                    'vision' => $i->vision,
                ];

                $improves[] = $improve;

                if ($i->target) {
                    ++$targetCount;
                    $targets[] = $improve;
                }
            }
        }

        $data = [
            'active' => 'test-profile',
            'profile' => $profile,
            'user' => $user,
            'isUsersProfile' => false,
            'editable' => false,
            'mock' => true,
            'satisfieds' => $satisfieds,
            'improves' => $improves,
            'targets' => $targets,
            'targetCount' => $targetCount,
            'canSeeEverything' => true,
        ];

        return view('statement.goals', $data);
    }

    public function getGoalsSelf(Request $request)
    {
        $user = Auth::user();
        $profile = $user->latestProfile();
        if (is_null($profile)) {
            abort(404);
        }

        return redirect(action('StatementController@getGoals', ['id' => $profile->id]));
    }

    public function getGoals(Request $request, $id)
    {
        $user = Auth::user();

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
            if (! $profile->accessibleBy($user)) {
                abort(403);
            }
        }

        if ($profile->in_progress) {
            $data = [
                'profile' => $profile,
                'user' => $user,
                'isUsersProfile' => $isUsersProfile,
                'editable' => $isUsersProfile && ! $profile->completed,
                'mock' => false,
                'canSeeEverything' => true,
            ];

            return view('statement.unfinished', $data);
        }

        $improve_db_1 = $profile->factors()->where('improve', 1)->get();
        $satisfieds = [];
        foreach ($improve_db_1 as $i) {
            $category = $i->category;
            if ($category) {
                $satisfieds[] = [
                    'label' => t($category->label),
                    'category_id' => $category->id,
                    'selected' => $i->satisfied,
                ];
            }
        }

        $improve_db_2 = $profile->factors()->where('improve', 2)->get();
        $improves = [];
        $targets = [];
        $targetCount = 0;
        foreach ($improve_db_2 as $i) {
            $category = $i->category;
            if ($category) {
                $improve = [
                    'label' => t($category->label),
                    'category_id' => $category->id,
                    'selected' => $i->target,
                    'value' => $i->value,
                    'vision' => $i->vision,
                ];

                $improves[] = $improve;

                if ($i->target) {
                    ++$targetCount;
                    $targets[] = $improve;
                }
            }
        }

        $data = [
            'active' => 'statement-goals',
            'profile' => $profile,
            'user' => $user,
            'isUsersProfile' => $isUsersProfile,
            'editable' => $isUsersProfile && ! $profile->completed,
            'mock' => false,
            'satisfieds' => $satisfieds,
            'improves' => $improves,
            'targets' => $targets,
            'targetCount' => $targetCount,
            'canSeeEverything' => true,
        ];

        return view('statement.goals', $data);
    }

    public function getPlanMock($results = false)
    {
        $user = Auth::user();
        if ($user->isStudent()) {
            abort(403);
        }

        $profile_id = config('fms.mock_profile');
        if (is_null($profile_id)) {
            abort(404);
        }

        $profile = Profile::findOrFail($profile_id);

        $texts = [];
        foreach ($profile->texts as $text) {
            $texts[$text->name] = $text->content;
        }

        $improve_db_1 = $profile->factors()->where('improve', 1)->get();
        $satisfieds = [];
        foreach ($improve_db_1 as $i) {
            $category = $i->category;
            if ($category) {
                $satisfieds[] = [
                    'label' => t($category->label),
                    'category_id' => $category->id,
                    'selected' => $i->satisfied,
                ];
            }
        }

        $improve_db_2 = $profile->factors()->where('improve', 2)->get();
        $improves = [];
        $targets = [];
        $targetCount = 0;
        foreach ($improve_db_2 as $i) {
            $category = $i->category;
            if ($category) {
                $improve = [
                    'label' => t($category->label),
                    'category_id' => $category->id,
                    'selected' => $i->target,
                    'value' => $i->value,
                    'vision' => $i->vision,
                ];

                $improves[] = $improve;

                if ($i->target) {
                    ++$targetCount;
                    $targets[] = $improve;
                }
            }
        }

        $data = [
            'active' => 'statement-plan',
            'profile' => $profile,
            'user' => $user,
            'isUsersProfile' => false,
            'editable' => false,
            'mock' => true,
            'texts' => $texts,
            'satisfieds' => $satisfieds,
            'improves' => $improves,
            'targets' => $targets,
            'targetCount' => $targetCount,
            'canSeeEverything' => true,
        ];

        if ($results) {
            return view('statement.plan-results', $data);
        }

        return view('statement.plan', $data);
    }

    public function getPlanSelf(Request $request)
    {
        $user = Auth::user();
        $profile = $user->latestProfile();
        if (is_null($profile)) {
            abort(404);
        }

        return redirect(action('StatementController@getPlan', ['id' => $profile->id]));
    }

    public function getPlan(Request $request, $id)
    {
        $user = Auth::user();

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
            if (! $profile->accessibleBy($user)) {
                abort(403);
            }
        }

        if ($profile->in_progress) {
            $data = [
                'profile' => $profile,
                'user' => $user,
                'isUsersProfile' => $isUsersProfile,
                'editable' => $isUsersProfile && ! $profile->completed,
                'mock' => false,
                'canSeeEverything' => $profile->canSeeEverything($user),
            ];

            return view('statement.unfinished', $data);
        }

        $texts = [];
        foreach ($profile->texts as $text) {
            $texts[$text->name] = $text->content;
        }

        $improve_db_1 = $profile->factors()->where('improve', 1)->get();
        $satisfieds = [];
        foreach ($improve_db_1 as $i) {
            $category = $i->category;
            if ($category) {
                $satisfieds[] = [
                    'label' => t($category->label),
                    'category_id' => $category->id,
                    'selected' => $i->satisfied,
                ];
            }
        }

        $improve_db_2 = $profile->factors()->where('improve', 2)->get();
        $improves = [];
        $targets = [];
        $targetCount = 0;
        foreach ($improve_db_2 as $i) {
            $category = $i->category;
            if ($category) {
                $improve = [
                    'label' => t($category->label),
                    'category_id' => $category->id,
                    'selected' => $i->target,
                    'value' => $i->value,
                    'vision' => $i->vision,
                ];

                $improves[] = $improve;

                if ($i->target) {
                    ++$targetCount;
                    $targets[] = $improve;
                }
            }
        }

        $data = [
            'active' => 'statement-plan',
            'profile' => $profile,
            'user' => $user,
            'isUsersProfile' => $isUsersProfile,
            'editable' => $isUsersProfile && ! $profile->completed,
            'mock' => false,
            'texts' => $texts,
            'satisfieds' => $satisfieds,
            'improves' => $improves,
            'targets' => $targets,
            'targetCount' => $targetCount,
            'canSeeEverything' => $profile->canSeeEverything($user),
        ];

        if ($profile->completed || ! $isUsersProfile) {
            return view('statement.plan-results', $data);
        }

        return view('statement.plan', $data);
    }

    public function postFinish(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        $user = Auth::user();
        if ($profile->user_id !== $user->id) {
            abort(403);
        }

        $profile->in_progress = false;
        $profile->completed = true;

        $profile->save();

        return back();
    }

    public function getCompareSelf(Request $request)
    {
        $user = Auth::user();
        $profile = $user->latestProfile();
        if (is_null($profile)) {
            abort(404);
        }

        return redirect(action('StatementController@getCompare', ['id' => $profile->id]));
    }

    public function getCompare(Request $request, $id, $other_id = null)
    {
        $user = Auth::user();

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
            if (! $profile->accessibleBy($user)) {
                abort(403);
            }
        }

        if ($profile->in_progress) {
            $data = [
                'profile' => $profile,
                'user' => $user,
                'isUsersProfile' => $isUsersProfile,
                'editable' => $isUsersProfile && ! $profile->completed,
                'mock' => false,
                'canSeeEverything' => true,
            ];

            return view('statement.unfinished', $data);
        }

        if (is_null($other_id)) {
            $profiles = Profile::where('user_id', $user->id)
                ->orderBy('date', 'DESC')
                ->get();

            $data = [
                'active' => 'statement-compare',
                'profile' => $profile,
                'user' => $user,
                'isUsersProfile' => $isUsersProfile,
                'editable' => $isUsersProfile && ! $profile->completed,
                'mock' => false,
                'profiles' => $profiles,
                'profilesCount' => $user->profiles()->count(),
                'canSeeEverything' => true,
            ];

            return view('statement.compare-select', $data);
        }

        $otherProfile = Profile::find($other_id);

        if ($otherProfile->user_id != $profile->user_id) {
            abort(403);
        }

        $labels = [];
        $profileValues = [];
        $otherProfileValues = [];

        foreach (ProfileFactor::sortedNames() as $name) {
            $labels[] = __('factors.' . $name);

            $factor = $profile->getFactorByName($name);
            if (! is_null($factor)) {
                $profileValues[] = intval($factor->value);
            } else {
                $profileValues[] = 0;
            }

            $factor = $otherProfile->getFactorByName($name);
            if (! is_null($factor)) {
                $otherProfileValues[] = intval($factor->value);
            } else {
                $otherProfileValues[] = 0;
            }
        }

        $data = [
            'active' => 'statement-compare',
            'id' => $id,
            'user' => $user,
            'isUsersProfile' => $isUsersProfile,
            'editable' => $isUsersProfile && ! $profile->completed,
            'mock' => false,
            'profile' => $profile,
            'otherProfile' => $otherProfile,
            'labels' => json_encode($labels),
            'profileValues' => json_encode($profileValues),
            'otherProfileValues' => json_encode($otherProfileValues),
            'canSeeEverything' => true,
        ];

        return view('statement.compare', $data);
    }

    private function pageFactors($profile, $page_id)
    {
        $page = QuestionnairePage::findOrFail($page_id);

        $categories = QuestionnaireCategory::where('page_name', $page->name)->get();

        $factors = [];
        foreach ($categories as $category) {
            $factor = ProfileFactor::where('profile_id', $profile->id)
                ->where('category_id', $category->id)->first();

            if (is_null($factor)) {
                $factor = new ProfileFactor;
                $factor->status = 'profile.unknown';
            }

            $factors[$category->name] = $factor;
        }

        if ($page->name == 'physical') {
            // Oxygen uptake test is not required if we have stepcount, and vice versa
            $hasFitness = isset($factors['fitness']) && $factors['fitness']->status != 'profile.unknown';
            $hasStepcount = isset($factors['stepcount']) && $factors['stepcount']->status != 'profile.unknown';

            if (! $hasFitness && $hasStepcount) {
                unset($factors['fitness']);
            }
            if (! $hasStepcount && $hasFitness) {
                unset($factors['stepcount']);
            }

            // Strength back is not required
            if (isset($factors['strBack']) && $factors['strBack']->status == 'profile.unknown') {
                unset($factors['strBack']);
            }
        }

        if ($page->name == 'physical_questions') {
            if (App::isLocale('en')) {
                // English version doesn't have IFIS questions
                unset($factors['physical']);
            } else {
                // IFIS is not required
                if (isset($factors['physical']) && $factors['physical']->status == 'profile.unknown') {
                    unset($factors['physical']);
                }
            }
        }

        if ($page->name == 'energy') {
            unset($factors['foodContents']);
            unset($factors['foodAmount']);
        }

        return $factors;
    }

    public function getAverage($id)
    {
        $profile = Profile::findOrFail($id);

        $result = [
            'slices' => [['Grupp', 'Storlek']],
            'colors' => [],
        ];

        $colors = ['white', '#f34f98', '#ea6c99', '#1c8c22', '#7ac143', '#7fe563'];

        $pages = QuestionnairePage::all();

        $hasPhysicalTests = false;
        $hasPhysicalQuestions = false;
        foreach ($pages as $page) {
            if ($page->name != 'physical' && $page->name != 'physical_questions') {
                continue;
            }
            $factors = $this->pageFactors($profile, $page->id);

            $hasKnown = false;
            foreach ($factors as $factor) {
                if ($factor->status != 'profile.unknown') {
                    $hasKnown = true;
                    break;
                }
            }

            if ($hasKnown) {
                if ($page->name == 'physical') {
                    $hasPhysicalTests = true;
                }
                if ($page->name == 'physical_questions') {
                    $hasPhysicalQuestions = true;
                }
            }
        }

        foreach ($pages as $page) {
            if ($page->name == 'physical') {
                if (! $hasPhysicalTests && $hasPhysicalQuestions) {
                    continue;
                }
            }
            if ($page->name == 'physical_questions') {
                if (! $hasPhysicalQuestions && $hasPhysicalTests) {
                    continue;
                }
            }

            $factors = $this->pageFactors($profile, $page->id);

            $total = 0;
            $hasUnknown = false;

            foreach ($factors as $factor) {
                $total += $factor->value;

                if ($factor->status == 'profile.unknown') {
                    $hasUnknown = true;
                }
            }

            $n_factors = count($factors);

            if (App::isLocale('sv')) {
                $page_label = $page->label_sv;
            } else {
                $page_label = $page->label_en;
            }

            $result['slices'][] = [
                $page_label,
                1,
            ];

            $result['pages'][] = $page->id;

            if ($hasUnknown) {
                $average = 0;
            } else {
                $average = $n_factors == 0 ? 0 : $total / $n_factors;
            }
            $result['colors'][] = $colors[round($average)];
        }

        return json_encode($result);
    }

    public function getFactors($id, $page_id)
    {
        $profile = Profile::findOrFail($id);

        $result = [
            'slices' => [['Grupp', 'Storlek']],
            'colors' => [],
        ];

        $colors = ['white', '#f34f98', '#ea6c99', '#1c8c22', '#7ac143', '#7fe563'];

        $factors = $this->pageFactors($profile, $page_id);

        foreach ($factors as $name => $factor) {
            $label = t('factors.' . $name);

            $result['slices'][] = [
                $label,
                1,
            ];

            if ($factor->status == 'profile.unknown') {
                $average = 0;
            } else {
                $average = $factor->value;
            }
            $result['colors'][] = $colors[intval($average)];
        }

        return json_encode($result);
    }

    public function postImprove(Request $request, $id)
    {
        // TODO: check permission

        $category_id = $request->input('category_id');
        $value = $request->input('value');

        $factor = ProfileFactor::where('profile_id', $id)
            ->where('category_id', $category_id)
            ->first();

        if (is_null($factor)) {
            abort(404);
        }

        $factor->improve = $value;
        $factor->save();

        return 'Saved!';
    }

    public function postSatisfied(Request $request, $id)
    {
        // TODO: check permission

        $category_id = $request->input('category_id');
        $value = $request->input('value');

        $factor = ProfileFactor::where('profile_id', $id)
            ->where('category_id', $category_id)
            ->first();

        $factor->satisfied = $value;
        $factor->save();

        return 'Saved!';
    }

    public function postTarget(Request $request, $id)
    {
        // TODO: check permission

        $category_id = $request->input('category_id');
        $value = $request->input('value');

        $factor = ProfileFactor::where('profile_id', $id)
            ->where('category_id', $category_id)
            ->first();

        $factor->target = $value;
        $factor->save();

        return 'Saved!';
    }

    public function postVision(Request $request, $id)
    {
        // TODO: check permission

        $category_id = $request->input('category_id');
        $value = $request->input('value');

        $factor = ProfileFactor::where('profile_id', $id)
            ->where('category_id', $category_id)
            ->first();

        $factor->vision = $value;
        $factor->save();

        return 'Saved!';
    }

    public function postText(Request $request, $id)
    {
        $user = Auth::user();

        $profile = Profile::findOrFail($id);

        $isUsersProfile = ($profile->user_id == $user->id);

        if (! $isUsersProfile) {
            abort(403);
        }

        $type = $request->input('type');
        $name = $request->input('name');
        $content = $request->input('content');

        if ($type == 'plan') {
            $profval = ProfileText::where('name', $name)
                ->where('profile_id', $id)->first();

            if (is_null($profval)) {
                $profval = new ProfileText;
                $profval->name = $name;
                $profval->profile_id = $id;
            }

            $profval->content = $content;
            $profval->save();
        } else {
            if (Str::contains($name, 'action')) {
                $name = str_replace('action', '', $name);

                $imprText = ProfileText::where('name', 'imprProfile')
                    ->where('profile_id', $profile->id)
                    ->first();

                if (is_null($imprText)) {
                    $imprText = new ProfileText;
                    $imprText->name = 'imprProfile';
                    $imprText->profile_id = $profile->id;

                    $improvements = [];
                } else {
                    $improvements = json_decode($imprText->content, true);
                }

                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('Det blev ett fel i JSON avkodningen. Fråga mig inte vad för fel det är!');
                }

                $planTexts = ProfileText::where('name', 'planProfile')
                    ->where('profile_id', $profile->id)
                    ->first();

                if (is_null($planTexts)) {
                    $planTexts = new ProfileText;
                    $planTexts->name = 'planProfile';
                    $planTexts->profile_id = $profile->id;

                    $plans = [];
                } else {
                    $plans = json_decode($planTexts->content, true);
                }

                if (empty($content)) {
                    if (in_array($name, $improvements)) {
                        $theKey = key($name, $improvements);
                        unset($theKey);
                        unset($plans[$name]);
                    }
                } else {
                    if (! in_array($name, $improvements)) {
                        $improvements[] = $name;
                    }
                    $plans[$name] = $content;
                }

                $imprText->content = json_encode($improvements);
                $planTexts->content = json_encode($plans);

                $imprText->save();
                $planTexts->save();
            } else {
                $name .= 'Profile';

                $text = ProfileText::where('name', $name)
                    ->where('profile_id', $profile->id)
                    ->first();

                if (is_null($text)) {
                    $text = new ProfileText;
                    $text->profile_id = $profile->id;
                    $text->name = $name;
                }

                $text->content = $content;

                $text->save();
            }
        }

        return 'Saved!';
    }
}
