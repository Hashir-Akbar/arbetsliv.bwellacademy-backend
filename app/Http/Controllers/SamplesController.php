<?php

namespace App\Http\Controllers;

use App\SampleGroup;
use App\SampleGroupMember;
use App\Section;
use App\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SamplesController extends Controller
{
    public function getList(Request $request)
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            $samplesObj = SampleGroup::all();
            $samples = [];
            foreach ($samplesObj as $obj) {
                $samples[] = $obj;
            }
        } elseif ($user->isStaff()) {
            $samplesObj = SampleGroup::where('unit_id', $user->unit_id)->get();
            $samples = [];
            foreach ($samplesObj as $obj) {
                $samples[] = $obj;
            }
        } else {
            abort(404);
        }

        uasort($samples, function ($a, $b) {
            return strcasecmp($a->label, $b->label);
        });

        $data = [
            'active' => 'sample',
            'user' => $user,
            'samples' => $samples,
        ];

        return view('admin.samples.list', $data);
    }

    public function getNew()
    {
        $user = Auth::user();

        $data = [
            'pageWithForm' => true,
        ];

        if ($user->isSuperAdmin()) {
            $data['units'] = Unit::all()->sortBy('name');
        } elseif ($user->isStaff()) {
            $data['unit'] = $user->unit;
        } else {
            abort(404);
        }

        return view('admin.samples.new', $data);
    }

    public function postNew(Request $request)
    {
        $unit_id = $request->input('unit');
        if (empty($unit_id)) {
            return Redirect::action('SamplesController@getNew')
                ->withErrors(['unit' => 'Du måste välja en enhet.'])
                ->withInput($request->all());
        }

        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::action('SamplesController@getNew')
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $group = new SampleGroup;
        $group->label = $request->input('name');
        $group->unit_id = $unit_id;
        $group->save();

        return Redirect::action('SamplesController@getList');
    }

    public function getEdit($id)
    {
        $sample = SampleGroup::findOrFail($id);

        // TODO: säkercheck

        $data = [
            'id' => $id,
            'name' => $sample->label,
            'pageWithForm' => true,
        ];

        return view('admin.samples.edit', $data);
    }

    public function postEdit(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::action('SamplesController@getEdit')
                ->withErrors($validator)
                ->withInput($request->all());
        } else {
            $sample = SampleGroup::findOrFail($id);
            $sample->label = $request->input('name');
            $sample->save();

            return Redirect::action('SamplesController@getList');
        }
    }

    public function getMembers($id)
    {
        $sample = SampleGroup::findOrFail($id);

        $members = $sample->members;

        $data = [
            'id' => $id,
            'sample' => $sample,
            'members' => $members,
        ];

        return view('admin.samples.members', $data);
    }

    public function getAddMember($id)
    {
        $admin = Auth::user();

        $sample = SampleGroup::findOrFail($id);

        $sampleMembers = $sample->members()->pluck('user_id');

        $sections = [];
        foreach (Section::where('unit_id', $sample->unit_id)->orderBy('name')->get() as $section) {
            $sectionName = $section->full_name();

            $sectionStudents = User::where('section_id', $section->id)
                ->whereNotIn('id', $sampleMembers)
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get();

            $students = [];
            foreach ($sectionStudents as $student) {
                $students[] = $student;
            }

            if (count($students) > 0) {
                $sections[$sectionName] = $students;
            }
        }

        $data = [
            'id' => $id,
            'sections' => $sections,
        ];

        return view('admin.samples.members.add', $data);
    }

    public function postAddMember(Request $request, $sampleId)
    {
        if (! $request->has('members')) {
            return Redirect::back()->withErrors(['members' => 'Du måste välja minst en användare.']);
        }

        $rules = [
            'members' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::action('SamplesController@getAddMember', ['id' => $sampleId])
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $newMembers = $request->input('members');

        foreach ($newMembers as $memberId) {
            $sample = new SampleGroupMember;
            $sample->sample_group_id = $sampleId;
            $sample->user_id = $memberId;
            $sample->save();
        }

        return Redirect::action('SamplesController@getMembers', ['id' => $sampleId]);
    }

    public function getRemoveMember($id, $userId)
    {
        $sample = SampleGroup::findOrFail($id);
        $user = User::findOrFail($userId);

        $exists = SampleGroupMember::where('sample_group_id', $id)
                    ->where('user_id', $userId)
                    ->first();

        if (is_null($exists)) {
            abort(404);
        }

        $data = [
            'sample' => $sample,
            'user' => $user,
        ];

        return view('admin.samples.members.remove', $data);
    }

    public function postRemoveMember($id, $userId)
    {
        $sample = SampleGroupMember::where('sample_group_id', $id)
                    ->where('user_id', $userId)
                    ->first();

        if (is_null($sample)) {
            abort(404);
        }

        $sample->delete();

        return Redirect::action('SamplesController@getMembers', compact('id'));
    }

    public function getDelete($id)
    {
        $sample = SampleGroup::findOrFail($id);

        $data = [
            'id' => $id,
            'name' => $sample->label,
        ];

        return view('admin.samples.delete', $data);
    }

    public function postDelete($id)
    {
        $sample = SampleGroup::findOrFail($id);
        $sample->delete();

        return Redirect::action('SamplesController@getList');
    }
}
