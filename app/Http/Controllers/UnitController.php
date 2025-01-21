<?php

namespace App\Http\Controllers;

use App\BusinessCategory;
use App\Country;
use App\County;
use App\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;

class UnitController extends Controller
{
    public function getList(Request $request)
    {
        $pageSize = 25;

        $user = Auth::user();
        if (! $user->isSuperAdmin()) {
            abort(403);
        }

        $unitsQuery = Unit::with('county', 'county.country');

        if (config('fms.type') === 'work') {
            $unitsQuery->with('business_category');
        }

        if ($request->has('search')) {
            $search = $request->get('search');

            $unitsQuery = $unitsQuery
                ->where('name', 'LIKE', "%$search%");
        }

        $paginationAppend = [];

        $sort = $request->query('sort');
        if (empty($sort)) {
            $sort = 'name';
        }
        $paginationAppend['sort'] = $sort;

        $sortType = $request->query('type');
        if (empty($sortType)) {
            $sortType = 'asc';
        }
        $paginationAppend['type'] = $sortType;

        if (in_array($sort, ['name']) && in_array($sortType, ['asc', 'desc'])) {
            $unitsQuery = $unitsQuery->orderBy($sort, $sortType);
        }

        $unitsQuery = $unitsQuery->orderBy('name', 'asc');

        $units = $unitsQuery->paginate($pageSize);

        if ($request->has('search')) {
            $paginationAppend['search'] = $request->get('search');
        }

        $data = [
            'active' => 'units',
            'user' => $user,
            'units' => $units,
            'sort' => $sort,
            'sortType' => $sortType,
            'search' => $request->get('search'),
            'paginationAppend' => $paginationAppend,
        ];

        return view('admin.units.list', $data);
    }

    public function getNew()
    {
        $user = Auth::user();
        if (! $user->isSuperAdmin()) {
            abort(403);
        }

        $countries = Country::orderBy('label')->get();
        $counties = County::orderBy('label')->get();

        $data = [
            'active' => 'units',
            'pageWithForm' => true,
            'countries' => $countries,
            'counties' => $counties,
            'counties_json' => json_encode($counties),
        ];

        if (config('fms.type') === 'work') {
            $data['businessCategories'] = BusinessCategory::all(['id', 'name']);
        }

        return view('admin.units.new', $data);
    }

    public function postNew(Request $request)
    {
        $currentUser = Auth::user();
        if (! $currentUser->isSuperAdmin()) {
            abort(403);
        }

        $rules = [
            'name' => 'required',
            'country' => 'required',
            // 'county' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required',
        ];

        if (config('fms.type') == 'school') {
            $rules['school_type'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->all());
        }

        $exists = User::where('email', $request->get('email'))->count() > 0;
        if ($exists) {
            if (App::isLocale('en')) {
                return back()->withErrors(['email' => 'A user with this email address already exists.'])->withInput();
            } else {
                return back()->withErrors(['email' => 'Det finns redan en användare med denna epostadress.'])->withInput();
            }
        }

        $unit = new Unit;
        $unit->name = $request->get('name');
        if (config('fms.type') == 'school') {
            $unit->school_type = 'unit.' . $request->get('school_type');
        }
        $unit->county_id = $request->get('county');
        $unit->email = $request->get('email');
        $unit->phone = $request->get('phone');
        $unit->business_category_id = $request->get('business_category') ?? null;
        $unit->save();

        $user = new User;

        $user->registration_code = generate_reg_code();

        $user->is_admin = true;
        $user->is_staff = true;

        $user->unit_id = $unit->id;

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');

        $user->save();

        $this->sendEmail($user);

        return redirect(url('/admin/units'));
    }

    public function sendEmail($user)
    {
        $name = $user->first_name;
        $data = [
            'id' => $user->id,
            'name' => $user->first_name,
            'code' => $user->registration_code,
            'from-email' => true,
        ];

        sendEmailToUser('emails.auth.staff_logins', 'emails.auth-staff_logins', $data, $user, compact('name'));
    }

    public function getEdit($id)
    {
        $user = Auth::user();
        if (! $user->isSuperAdmin()) {
            abort(403);
        }

        $unit = Unit::findOrFail($id);

        $countries = Country::orderBy('label')->get();
        $counties = County::orderBy('label')->get();

        $data = [
            'id' => $id,
            'pageWithForm' => true,
            'unit' => $unit,
            'countries' => $countries,
            'counties' => $counties,
            'counties_json' => json_encode($counties),
        ];

        if (config('fms.type') === 'work') {
            $data['businessCategories'] = BusinessCategory::all(['id', 'name']);
        }

        return view('admin.units.edit', $data);
    }

    public function postEdit(Request $request, $id)
    {
        $user = Auth::user();
        if (! $user->isSuperAdmin()) {
            abort(403);
        }

        $rules = [
            'name' => 'required',
            'country' => 'required',
            // 'county' => 'required',
        ];

        if (config('fms.type') == 'school') {
            $rules['school_type'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->all());
        }

        $unit = Unit::findOrFail($id);
        $unit->name = $request->get('name');
        if (config('fms.type') == 'school') {
            $unit->school_type = 'unit.' . $request->get('school_type');
        }
        $unit->county_id = $request->get('county');
        $unit->email = $request->get('email');
        $unit->phone = $request->get('phone');
        $unit->business_category_id = $request->get('business_category') ?? null;
        $unit->save();

        return redirect(url('/admin/units'));
    }

    public function getDelete($id)
    {
        $user = Auth::user();
        if (! $user->isSuperAdmin()) {
            abort(403);
        }

        $unit = Unit::findOrFail($id);

        $data = [
            'id' => $id,
            'unit' => $unit,
        ];

        return view('admin.units.delete', $data);
    }

    public function postDelete($id)
    {
        $user = Auth::user();
        if (! $user->isSuperAdmin()) {
            abort(403);
        }

        $unit = Unit::findOrFail($id);

        $unit->delete();

        return redirect(url('/admin/units'));
    }
}
