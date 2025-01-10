<?php

namespace App\Http\Controllers;

use App\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function getList(Request $request)
    {
        $pageSize = 25;

        $currentUser = Auth::user();

        if (! $currentUser->canDo('create_staff')) {
            abort(403);
        }

        if ($currentUser->isSuperAdmin()) {
            $units = Unit::all();
            $unit = null;
        } else {
            $units = Unit::where('id', $currentUser->unit_id)->get();
            $unit = $units->first();
        }

        $usersQuery = User::whereIn('unit_id', $units->pluck('id'));

        if ($request->has('unit')) {
            $unit = $units->find($request->query('unit'));
            if (is_null($unit)) {
                abort(404);
            }

            $usersQuery = $usersQuery
                ->where('unit_id', $unit->id);
        }

        if ($request->has('search')) {
            $search = $request->get('search');

            $usersQuery = $usersQuery
                ->where(DB::raw('lower(concat(`users`.`first_name`, " ", `users`.`last_name`))'), 'LIKE', "%$search%");
        }

        $paginationAppend = [];

        $sort = $request->query('sort');
        if (empty($sort)) {
            $sort = 'first_name';
        }
        $paginationAppend['sort'] = $sort;

        $sortType = $request->query('type');
        if (empty($sortType)) {
            $sortType = 'asc';
        }
        $paginationAppend['type'] = $sortType;

        if (in_array($sort, ['first_name', 'last_name']) && in_array($sortType, ['asc', 'desc'])) {
            $usersQuery = $usersQuery
                ->orderBy($sort, $sortType);
        }

        $usersQuery = $usersQuery
            ->orderBy('first_name', 'asc')->orderBy('last_name', 'asc');

        $users = $usersQuery
            ->paginate($pageSize);

        $data = [
            'currentUser' => $currentUser,
            'unit' => $unit,
            'showingUnit' => ! is_null($unit),
            'users' => $users,
            'sort' => $sort,
            'sortType' => $sortType,
            'search' => $request->get('search'),
            'paginationAppend' => $paginationAppend,
        ];

        return view('admin.staff.list', $data);
    }

    public function getNew($unit_id)
    {
        $currentUser = Auth::user();

        $unit = Unit::findOrFail($unit_id);

        if (! $currentUser->canDo('create_staff') || ! $unit->accessibleBy($currentUser)) {
            abort(403);
        }

        $data = [
            'currentUser' => $currentUser,
            'unit' => $unit,
        ];

        return view('admin.staff.new', $data);
    }

    public function postNew(Request $request, $unit_id)
    {
        $currentUser = Auth::user();

        $unit = Unit::findOrFail($unit_id);

        if (! $currentUser->canDo('create_staff') || ! $unit->accessibleBy($currentUser)) {
            abort(403);
        }

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $exists = User::where('email', $request->get('email'))->count() > 0;
        if ($exists) {
            if (App::isLocale('en')) {
                return back()->withErrors(['email' => 'A user with this email address already exists.'])->withInput();
            } else {
                return back()->withErrors(['email' => 'Det finns redan en användare med denna epostadress.'])->withInput();
            }
        }

        $user = new User;

        $user->registration_code = generate_reg_code();

        $user->is_staff = true;
        $user->unit_id = $unit_id;

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');

        $roles = $request->get('roles') ?? [];

        $user->is_admin = in_array('admin', $roles);

        if ($currentUser->isSuperAdmin()) {
            $user->is_nurse = in_array('nurse', $roles);
            $user->is_physical_trainer = in_array('physical_trainer', $roles);
        }

        $user->save();

        $this->sendEmail($user);

        return redirect(url('/admin/staff?unit=' . $unit->id));
    }

    public function getEdit($id)
    {
        $currentUser = Auth::user();

        $user = User::findOrFail($id);

        if (! $currentUser->canDo('create_staff') || ! $currentUser->isStaffOf($user)) {
            abort(403);
        }

        $data = [
            'currentUser' => $currentUser,
            'unit' => $user->unit,
            'user' => $user,
        ];

        return view('admin.staff.edit', $data);
    }

    public function postEdit(Request $request, $id)
    {
        $currentUser = Auth::user();

        $user = User::findOrFail($id);

        if (! $currentUser->canDo('create_staff') || ! $currentUser->isStaffOf($user)) {
            abort(403);
        }

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $email = $request->input('email');
        if ($email != $user->email) {
            $exists = User::where('email', $email)->count() > 0;

            if ($exists) {
                if (App::isLocale('en')) {
                    return back()->withErrors(['email' => 'A user with this email address already exists.'])->withInput();
                } else {
                    return back()->withErrors(['email' => 'Det finns redan en användare med denna epostadress.'])->withInput();
                }
            }

            // TODO: confirm email

            $user->email = $email;
        }

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');

        $roles = $request->get('roles') ?? [];

        $user->is_admin = in_array('admin', $roles);

        if ($currentUser->isSuperAdmin()) {
            $user->is_nurse = in_array('nurse', $roles);
            $user->is_physical_trainer = in_array('physical_trainer', $roles);
        }

        $user->save();

        return redirect(url('/admin/staff?unit=' . $user->unit_id));
    }

    public function getDelete($id)
    {
        $currentUser = Auth::user();

        $user = User::findOrFail($id);

        if (! $currentUser->canDo('create_staff') || ! $currentUser->isStaffOf($user)) {
            abort(403);
        }

        $unit = Unit::findOrFail($user->unit_id);

        $data = [
            'currentUser' => $currentUser,
            'user' => $user,
            'unit' => $unit,
        ];

        return view('admin.staff.delete', $data);
    }

    public function postDelete(Request $request, $id)
    {
        $currentUser = Auth::user();

        $user = User::findOrFail($id);

        if (! $currentUser->canDo('create_staff') || ! $currentUser->isStaffOf($user)) {
            abort(403);
        }

        $user->delete();

        return redirect(url('/admin/staff?unit=' . $user->unit_id));
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

    public function postDeactivate(Request $request, User $user)
    {
        $user->update(['deactivated_at' => now()]);

        return redirect()->back();
    }

    public function postActivate(Request $request, User $user)
    {
        $user->update(['deactivated_at' => null]);

        return redirect()->back();
    }
}
