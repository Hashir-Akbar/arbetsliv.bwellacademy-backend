<?php

namespace App\Http\Controllers;

use App\SecondaryProgram;
use App\Section;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    public function getList(Request $request)
    {
        $pageSize = 25;

        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            $units = Unit::all();
            $unit = null;
        } else {
            $units = Unit::where('id', $user->unit_id)->get();
            $unit = $units->first();
        }

        $sectionsQuery = Section::whereIn('unit_id', $units->pluck('id'));

        if (!$request->has('show-archived')) {
            $sectionsQuery->whereNull('archived_at');
        }

        if ($request->has('unit')) {
            $unit = $units->find($request->query('unit'));
            if (is_null($unit)) {
                abort(404);
            }

            $sectionsQuery = $sectionsQuery
                ->where('unit_id', $unit->id);
        }

        if ($request->has('search')) {
            $search = $request->get('search');

            $sectionsQuery = $sectionsQuery
                ->where('name', 'LIKE', "%$search%");
        }

        $sort = $request->query('sort', 'name');
        $sortType = $request->query('type', 'asc');

        $paginationAppend = [
            'sort' => $sort,
            'type' => $sortType,
        ];

        if (in_array($sort, ['name', 'school_year', 'completed']) && in_array($sortType, ['asc', 'desc'])) {
            $sectionsQuery = $sectionsQuery
                ->orderBy($sort, $sortType);
        }

        $sectionsQuery = $sectionsQuery
            ->orderBy('name', 'asc')->orderBy('school_year', 'asc');

        $sections = $sectionsQuery
            ->paginate($pageSize);

        if (! is_null($unit)) {
            $paginationAppend['unit'] = $unit->id;
        }
        if ($request->has('search')) {
            $paginationAppend['search'] = $request->get('search');
        }

        return view('admin.sections.list', [
            'active' => 'sections',
            'user' => $user,
            'unit' => $unit,
            'units' => $units,
            'showingUnit' => ! is_null($unit),
            'sections' => $sections,
            'sort' => $sort,
            'sortType' => $sortType,
            'search' => $request->get('search'),
            'showArchived' => $request->has('show-archived'),
            'paginationAppend' => $paginationAppend,
        ]);
    }

    public function getNew($unit_id)
    {
        $user = Auth::user();

        $unit = Unit::findOrFail($unit_id);

        if (! $user->canDo('create_sections') || ! $unit->accessibleBy($user)) {
            abort(403);
        }

        if (config('fms.type') == 'work') {
            $type = 'division';
        } else {
            $type = 'class';
        }

        $data = [
            'active' => 'sections',
            'unit' => $unit,
            'user' => $user,
            'pageWithForm' => true,
        ];

        if ($type == 'class') {
            $view = 'admin.sections.new-class';
            $data['programs'] = SecondaryProgram::orderBy('label', 'asc')->get();
        } else {
            $view = 'admin.sections.new-division';
        }

        return view($view, $data);
    }

    public function postNew(Request $request, $unit_id)
    {
        $user = Auth::user();

        $unit = Unit::findOrFail($unit_id);

        if (! $user->canDo('create_sections') || ! $unit->accessibleBy($user)) {
            abort(403);
        }

        if (config('fms.type') == 'work') {
            $type = 'division';
        } else {
            $type = 'class';
        }

        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $section = new Section;
        $section->unit_id = $unit_id;
        $section->name = $request->input('name');

        if ($type == 'class') {
            $section->type = 'section.class';
            $section->school_year = $request->input('school_year');
            $pid = $request->input('program');
            $section->program_id = $pid > 0 ? $pid : null;
        } else {
            $section->type = 'section.division';
        }

        $section->save();

        return redirect(url('/admin/sections?unit=' . $unit_id));
    }

    public function getEdit($id)
    {
        $user = Auth::user();

        $section = Section::findOrFail($id);

        if (! $user->canDo('create_sections') || ! $section->accessibleBy($user)) {
            abort(403);
        }

        $data = [
            'section' => $section,
            'id' => $id,
            'pageWithForm' => true,
        ];

        if (config('fms.type') == 'school') {
            $secondaryPrograms = SecondaryProgram::all();
            $programs = [];
            foreach ($secondaryPrograms as $program) {
                $programs[] = $program;
            }
            uasort($programs, function ($a, $b) {
                return strcasecmp($a->label, $b->label);
            });
            $data['programs'] = $programs;

            return view('admin.sections.edit-class', $data);
        } else {
            return view('admin.sections.edit-division', $data);
        }
    }

    public function postEdit(Request $request, $id)
    {
        $user = Auth::user();

        $section = Section::findOrFail($id);

        if (! $user->canDo('create_sections') || ! $section->accessibleBy($user)) {
            abort(403);
        }

        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::action('SectionController@getEdit')
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $section->name = $request->input('name');

        if (config('fms.type') == 'school') {
            $section->school_year = $request->input('school_year');
            $pid = $request->input('program');
            $section->program_id = $pid > 0 ? $pid : null;
        }

        $section->completed = $request->has('completed');

        $section->save();

        return redirect(url('/admin/sections?unit=' . $section->unit_id));
    }

    public function getDelete($id)
    {
        $user = Auth::user();

        $section = Section::findOrFail($id);

        if (! $user->canDo('create_sections') || ! $section->accessibleBy($user)) {
            abort(403);
        }

        $data = [
            'section' => $section,
            'user' => Auth::user(),
            'id' => $id,
        ];

        return view('admin.sections.delete', $data);
    }

    public function postDelete($id)
    {
        $user = Auth::user();

        $section = Section::findOrFail($id);

        if (! $user->canDo('create_sections') || ! $section->accessibleBy($user)) {
            abort(403);
        }

        $section->delete();

        return redirect(url('/admin/sections?unit=' . $section->unit_id));
    }

    public function getArchive($id)
    {
        $user = Auth::user();

        $section = Section::findOrFail($id);

        if (! $user->canDo('create_sections') || ! $section->accessibleBy($user)) {
            abort(403);
        }

        $data = [
            'section' => $section,
            'user' => Auth::user(),
            'id' => $id,
        ];

        return view('admin.sections.archive', $data);
    }

    public function postArchive($id)
    {
        $user = Auth::user();

        $section = Section::findOrFail($id);

        if (! $user->canDo('create_sections') || ! $section->accessibleBy($user)) {
            abort(403);
        }

        $section->update(['archived_at' => now()]);

        return redirect(url('/admin/sections?unit=' . $section->unit_id));
    }

    
}
