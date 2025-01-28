<?php

namespace App\Http\Controllers;
use App\Section;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['student.sex-set', 'student.terms-accepted']);
    }

    public function getIndex(Request $request)
    {
        $user = $request->user();

        if ($user->isSuperAdmin()) {
            $sections = Section::all();
        } else {
            $sections = Section::where('unit_id', $user->unit_id)->get();
        }

        return view($user->isStudent() ? 'tiles-student' : 'tiles-staff', [
            'user' => $user,
            'active' => 'panel',
            'help' => 'panel',
            'cssClasses' => 'tiles-page',
            'sections' => $sections,
        ]);
    }
}
