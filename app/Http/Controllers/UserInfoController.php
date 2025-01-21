<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends Controller
{
    public function getSetSex()
    {
        $user = Auth::user();

        $data = ['user' => $user];

        return view('questionnaire.set-sex', $data);
    }

    public function postSetSex(Request $request)
    {
        $user = Auth::user();

        $user->sex = $request->input('sex');
        $user->save();

        return redirect(url('/'));
    }

    public function getTerms()
    {
        return view('questionnaire.terms');
    }

    public function postTerms(Request $request)
    {
        $user = Auth::user();

        $accept = $request->input('accept');

        if ($accept == 'Ja' || $accept == 'Yes') {
            $user->accepted = true;
        } else {
            $user->accepted = false;
        }
        $user->save();

        return redirect(url('/'));
    }

    public function getShow($uid)
    {
        $student = User::findOrFail($uid);

        $user = Auth::user();

        if ($user->isStudent()) {
            abort(404);
        }

        $canSee = false;
        $canSeeEverything = false;

        if ($user->isSuperAdmin()) {
            $canSee = true;
            $canSeeEverything = true;
        } else {
            if ($user->isAdmin()) {
                return view('user_info.access_denied');
            }
            if (! $user->isStaffOf($student)) {
                return view('user_info.access_denied');
            }

            if ($user->isNurse()) {
                $canSee = true;
                $canSeeEverything = true;
            }
        }

        $data = [
            'user' => $student,
            'canSee' => $canSee,
            'canSeeEverything' => $canSeeEverything,
        ];

        return view('user_info.show', $data);
    }

    public function getEdit()
    {
        $user = Auth::user();

        $data = [
            'user' => $user,
            'profile' => $user->info,
            'pageWithForm' => true,
        ];

        return view('user_info.edit')->with($data);
    }

    public function getPassword()
    {
        $user = Auth::user();

        $data = [
            'user' => $user,
            'profile' => $user->info,
            'pageWithForm' => true,
        ];

        return view('user_info.password')->with($data);
    }
}
