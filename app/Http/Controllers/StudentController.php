<?php

namespace App\Http\Controllers;

use App\Section;
use App\Unit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class StudentController extends Controller
{
    public function getList(Request $request)
    {
        $pageSize = 25;

        /** @var \App\User $user */
        $user = $request->user();

        $data = [
            'user' => $user,
            'active' => 'students',
        ];

        if ($user->isSuperAdmin()) {
            $units = Unit::all();
            $sections = Section::all();
        } else {
            $units = Unit::where('id', $user->unit_id)->get();
            $sections = Section::where('unit_id', $user->unit_id)->get();
        }

        $data['sections'] = $sections;

        if ($units->count() < 1) {
            return view('admin.students.no-units');
        }

        if ($sections->count() < 1) {
            $unit_id = $units->first()->id;

            return view('admin.students.no-sections', compact('unit_id'));
        }

        $studentsQuery = User::with('section');

        // only show students from sections we have access to
        $studentsQuery = $studentsQuery
            ->whereIn('users.section_id', $sections->pluck('id'));

        if ($request->has('search')) {
            $search = $request->get('search');
            $specificPersonSearch = false;

            $pattern = "/(19\d{6}|20\d{6}|\d{6}|19[\d-]{8}|20[\d-]{8}|[\d-]{8})[ -]?(\d{4})?/";
            $matches = [];

            if (preg_match($pattern, $search, $matches)) {
                $dateToSearch = $matches[1];
                $matchLength = strlen($dateToSearch);

                switch ($matchLength) {
                    case 6:
                        $format = 'ymd';
                        break;
                    case 8:
                        if (! Str::contains($dateToSearch, '-')) {
                            $format = 'Ymd';
                        } else {
                            $format = 'y-m-d';
                        }
                        break;
                    case 10:
                        $format = 'Y-m-d';
                        break;
                }

                if (isset($format)) {
                    try {
                        $birth_date = \Carbon\Carbon::createFromFormat($format, $dateToSearch);
                        $specificPersonSearch = true;
                    } catch (InvalidArgumentException $e) {
                    }
                }
            }

            if ($specificPersonSearch) {
                $studentsQuery = $studentsQuery
                    ->where('users.birth_date', $birth_date->toDateString());

                $data['showingSection'] = false;
            } else {
                $studentsQuery = $studentsQuery
                    ->where(DB::raw('lower(concat(`users`.`first_name`, " ", `users`.`last_name`))'), 'LIKE', "%$search%");
            }
        }

        if ($request->has('section')) {
            $section = Section::findOrFail($request->query('section'));

            // make sure we have access to the section
            if (! $user->isSuperAdmin()) {
                if ($section->unit_id != $user->unit_id) {
                    abort(403);
                }
            }

            $studentsQuery = $studentsQuery
                ->where('users.section_id', $section->id);

            $data['showingSection'] = true;
            $data['section'] = $section;
        } else {
            $data['showingSection'] = false;
        }

        $sort = $request->query('sort') ?? 'first_name';
        $sortType = $request->query('type') ?? 'asc';

        $paginationAppend = [
            'sort' => $sort,
            'type' => $sortType,
        ];

        if (in_array($sort, ['first_name', 'last_name', 'sex', 'birth_date', 'is_test']) && in_array($sortType, ['asc', 'desc'])) {
            $studentsQuery = $studentsQuery->orderBy($sort, $sortType);
        }

        $studentsQuery = $studentsQuery->orderBy('first_name', 'asc')->orderBy('last_name', 'asc');

        $students = $studentsQuery->paginate($pageSize);

        $data['students'] = $students;

        $data['search'] = $request->get('search');
        $data['sort'] = $sort;
        $data['sortType'] = $sortType;

        if ($data['showingSection']) {
            $paginationAppend['section'] = $section->id;
        }
        if ($request->has('search')) {
            $paginationAppend['search'] = $request->get('search');
        }
        $data['paginationAppend'] = $paginationAppend;

        return view('admin.students.list')->with($data);
    }

    public function getNewMultiple(Request $request, $section_id)
    {
        /** @var \App\User $currentUser */
        $currentUser = $request->user();

        $section = Section::findOrFail($section_id);

        if (! $currentUser->canDo('create_students') || ! $section->accessibleBy($currentUser)) {
            abort(403);
        }

        if (is_null($section->secret_code)) {
            $section->secret_code = strtoupper(Str::random(5)); // Generate a random secret code of 5 uppercase characters
            $section->save();
        }

        $qrCode = new QrCode(config('app.url') . '/register?id=' . $section_id);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Store the QR code string in the section
        $qr_code = $result->getString();

        $data = [
            'section' => $section,
            'pageWithForm' => true,
            'qr_code' => $qr_code,
        ];

        return view('admin.students.new-multiple', $data);
    }

    public function postNewMultiple(Request $request, $section_id)
    {
        /** @var \App\User $currentUser */
        $currentUser = $request->user();

        $section = Section::findOrFail($section_id);

        if (! $currentUser->canDo('create_students') || ! $section->accessibleBy($currentUser)) {
            abort(403);
        }

        $users = $request->get('users');
        $emails = [];
        $hasErrors = false;

        for ($i = 0; $i < count($users); ++$i) {
            $users[$i]['error'] = '';

            if (! isset($users[$i]['first_name']) || ! isset($users[$i]['last_name']) || ! isset($users[$i]['birth_date'])) {
                $users[$i]['error'] .= 'Eleven på rad ' . ($i + 1) . " saknar ett obligatoriskt fält.<br>\n";

                $hasErrors = true;

                continue;
            }

            if (strlen($users[$i]['first_name']) < 1) {
                $users[$i]['error'] .= 'Förnamn på rad ' . ($i + 1) . " är tomt.<br>\n";

                $hasErrors = true;
            }

            if (strlen($users[$i]['last_name']) < 1) {
                $users[$i]['error'] .= 'Efternamn på rad ' . ($i + 1) . " är tomt.<br>\n";

                $hasErrors = true;
            }

            if (strlen($users[$i]['email']) > 0) {
                $validator = Validator::make(['email' => $users[$i]['email']], ['email' => 'email']);

                if ($validator->fails()) {
                    $users[$i]['error'] .= 'Emailadress på rad ' . ($i + 1) . " är felaktigt.<br>\n";
                    $hasErrors = true;
                }

                $email = $users[$i]['email'];
                $exists = User::where('email', $email)->first();
                if (! is_null($exists)) {
                    $users[$i]['error'] .= 'Det finns redan en användare med den emailadressen på rad ' . ($i + 1) . ".<br>\n";
                    $hasErrors = true;
                }

                if (in_array($email, $emails)) {
                    $users[$i]['error'] .= 'Emailadresser måste vara unika, emailadressen på rad ' . ($i + 1) . " är redan med i listan.<br>\n";
                    $hasErrors = true;
                }

                $emails[] = $email;
            }

            if (strlen($users[$i]['birth_date']) > 0) {
                $validator = Validator::make(['birth_date' => $users[$i]['birth_date']], ['birth_date' => 'required|date']);

                if ($validator->fails()) {
                    $users[$i]['error'] .= 'Födelsedatum på rad ' . ($i + 1) . " är inte ett giltigt datum.<br>\n";
                    $hasErrors = true;
                }
            } else {
                $users[$i]['error'] .= 'Födelsedatum på rad ' . ($i + 1) . " är tomt.<br>\n";
                $hasErrors = true;
            }
        }

        if ($hasErrors) {
            return back()
                ->with('section', $section)
                ->with('old_data', $users);
        }

        foreach ($users as $userInfo) {
            $u = new User;

            $u->first_name = $userInfo['first_name'];
            $u->last_name = $userInfo['last_name'];

            if (strlen($userInfo['email']) > 0) {
                $u->email = $userInfo['email'];
            }

            $u->birth_date = \Carbon\Carbon::parse($userInfo['birth_date']);

            $u->sex = $userInfo['sex'];

            $u->registration_code = generate_reg_code();
            $u->section_id = $section_id;

            $u->is_test = $request->has('is_test');

            $u->save();

            if (! empty($u->email)) {
                $this->sendEmail($u);
            }
        }

        return redirect(url('/admin/students?section=' . $section_id));
    }

    public function getImport(Request $request, $section_id)
    {
        /** @var \App\User $currentUser */
        $currentUser = $request->user();

        $section = Section::findOrFail($section_id);

        if (! $currentUser->canDo('create_students') || ! $section->accessibleBy($currentUser)) {
            abort(403);
        }

        return view('admin.students.import', ['section' => $section, 'sectionId', $section_id]);
    }

    public function postImport(Request $request, $section_id)
    {
        /** @var \App\User $currentUser */
        $currentUser = $request->user();

        $section = Section::findOrFail($section_id);

        if (! $currentUser->canDo('create_students') || ! $section->accessibleBy($currentUser)) {
            abort(403);
        }

        $rules = [
            'file' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->action('StudentController@getImport', [$section_id])
                ->withErrors($validator);
        }

        $uploadedFile = $request->file('file');

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');

        try {
            $spreadsheet = $reader->load($uploadedFile);
        } catch (\Exception $e) {
            return redirect()->action('StudentController@getImport', [$section_id])
                ->withErrors(['file' => 'Kunde inte läsa filen.']);
        }

        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->getHighestRow();

        $errors = [];
        $users = [];
        $isTest = false;

        $start_row = 1;
        if ($rows > 0) {
            $cell = $worksheet->getCellByColumnAndRow(1, 1)->getValue();

            $cell = mb_strtolower($cell);

            if ($cell === 'förnamn' || $cell === 'first name') {
                $start_row = 2;
            }
        }

        for ($row = $start_row; $row <= $rows; ++$row) {
            // name
            $first_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
            $last_name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

            // skip row if null
            if ($first_name === null) {
                continue;
            }

            if (empty($first_name) || empty($last_name)) {
                $errors[] = 'Användaren på rad ' . $row . ' måste ha ett förnamn och efternamn.';

                continue;
            }

            // email
            $email = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
            if (empty($email)) {
                $errors[] = 'Användaren på rad ' . $row . ' måste ha en emailadress.';

                continue;
            }
            $validator = Validator::make(['email' => $email], ['email' => 'email']);
            if ($validator->fails()) {
                $errors[] = 'Användaren på rad ' . $row . ' har en felaktig emailadress.';

                continue;
            }
            $exists = User::where('email', $email)->count() > 0;
            if ($exists) {
                $errors[] = 'Användaren på rad ' . $row . ' finns redan.';

                continue;
            }

            // birth_date
            $cell = $worksheet->getCellByColumnAndRow(4, $row);
            if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($cell)) {
                try {
                    $dt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cell->getValue());
                    $birth_date = $dt->format('Y-m-d');
                } catch (\Exception $e) {
                    $birth_date = null;
                }
            } else {
                $birth_date = $cell->getValue();
            }
            if (empty($birth_date)) {
                $errors[] = 'Användaren på rad ' . $row . ' måste ha ett födelsedatum.';

                continue;
            }
            $validator = Validator::make(['date' => $birth_date], ['date' => 'date']);
            if ($validator->fails()) {
                $errors[] = 'Användaren på rad ' . $row . ' har ett felaktigt födelsedatum.';

                continue;
            }

            // sex
            $sex = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
            $sex = strtoupper($sex);
            if ($sex == 'FEMALE' || $sex == 'KVINNA') {
                $sex = 'F';
            }
            if ($sex == 'MALE' || $sex == 'MAN') {
                $sex = 'M';
            }
            if (empty($sex) || ($sex != 'F' && $sex != 'M')) {
                $errors[] = 'Användaren på rad ' . $row . ' har ett okänt kön.';

                continue;
            }

            $users[] = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'birth_date' => $birth_date,
                'email' => $email,
                'sex' => $sex,
            ];
        }

        if (count($errors) > 0) {
            return redirect()->action('StudentController@getImport', [$section_id])
                ->withErrors(['file' => $errors]);
        }

        Session::put('import_users', $users);

        return view('admin.students.import-preview', ['users' => $users, 'section' => $section, 'isTest' => $isTest]);
    }

    public function postCompleteImport(Request $request, $section_id)
    {
        /** @var \App\User $currentUser */
        $currentUser = $request->user();

        $section = Section::findOrFail($section_id);

        if (! $currentUser->canDo('create_students') || ! $section->accessibleBy($currentUser)) {
            abort(403);
        }

        $users = Session::get('import_users');

        foreach ($users as $user) {
            $u = new User;

            $u->first_name = $user['first_name'];
            $u->last_name = $user['last_name'];
            $u->birth_date = $user['birth_date'];
            $u->sex = $user['sex'];
            if (! empty($user['email'])) {
                $u->email = $user['email'];
            }

            $u->registration_code = generate_reg_code();
            $u->section_id = $section_id;

            $u->save();

            if (isset($u->email)) {
                $this->sendEmail($u);
            }
        }

        return redirect(url('/admin/students?section=' . $section_id));
    }

    public function getEdit(Request $request, $id)
    {
        /** @var \App\User $currentUser */
        $currentUser = $request->user();

        $user = User::findOrFail($id);

        if (! $currentUser->canDo('create_students') || ! $currentUser->isStaffOf($user)) {
            abort(403);
        }

        if (! is_null($user->section_id)) {
            $unit = $user->section->unit;
        } else {
            $unit = null;
        }

        $data = [
            'user' => $user,
            'unit' => $unit,
            'pageWithForm' => true,
        ];

        return view('admin.students.edit', $data);
    }

    public function postEdit(Request $request, $id)
    {
        /** @var \App\User $currentUser */
        $currentUser = $request->user();

        $user = User::findOrFail($id);

        if (! $currentUser->canDo('create_students') || ! $currentUser->isStaffOf($user)) {
            abort(403);
        }

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required|date',
            'sex' => 'required',
            'section' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');

        if ($request->has('email')) {
            $user->email = $request->get('email');
        }

        $user->birth_date = \Carbon\Carbon::parse($request->get('birth_date'));

        $user->sex = $request->get('sex');

        $user->section_id = $request->get('section');

        $user->is_test = $request->has('is_test');

        $user->save();

        return redirect(url('/admin/students?section=' . $user->section_id));
    }

    public function getDelete(Request $request, $id)
    {
        /** @var \App\User $currentUser */
        $currentUser = $request->user();

        $user = User::findOrFail($id);

        if (! $currentUser->canDo('create_students') || ! $currentUser->isStaffOf($user)) {
            abort(403);
        }

        $data = [
            'id' => $id,
            'user' => $user,
        ];

        return view('admin.students.delete', $data);
    }

    public function postDelete(Request $request, $id)
    {
        /** @var \App\User $currentUser */
        $currentUser = $request->user();

        $user = User::findOrFail($id);

        if (! $currentUser->canDo('create_students') || ! $currentUser->isStaffOf($user)) {
            abort(403);
        }

        $user->delete();

        return redirect(url('/admin/students?section=' . $user->section_id));
    }

    public function getRegInfo(Request $request, $id)
    {
        /** @var \App\User $currentUser */
        $currentUser = $request->user();

        $user = User::findOrFail($id);

        if (! $currentUser->canDo('create_students') || ! $currentUser->isStaffOf($user)) {
            abort(403);
        }

        return view('admin.students.reg-info')->with('users', [$user]);
    }

    public function getRegInfoSection(Request $request, $section_id)
    {
        /** @var \App\User $currentUser */
        $currentUser = $request->user();

        $section = Section::findOrFail($section_id);

        if (! $currentUser->canDo('create_students') || ! $section->accessibleBy($currentUser)) {
            abort(403);
        }

        $users = $section->users->sortBy(fn ($user) => [strtolower($user->first_name), strtolower($user->last_name)]);

        return view('admin.students.reg-info')->with('users', $users);
    }

    public function sendEmail($user)
    {
        $name = $user->first_name;
        $data = [
            'id' => $user->id,
            'name' => $name,
            'code' => $user->registration_code,
            'from-email' => true,
        ];

        sendEmailToUser('emails.auth.new_user', 'emails.auth-new_user', $data, $user, compact('name'));
    }
}
