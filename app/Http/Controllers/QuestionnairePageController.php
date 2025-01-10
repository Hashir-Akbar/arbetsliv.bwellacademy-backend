<?php

namespace App\Http\Controllers;

use App\QuestionnairePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class QuestionnairePageController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.super');
    }

    public function getList()
    {
        $pages = QuestionnairePage::orderBy('id')->get();

        $data = [
            'active' => 'questionnaire',
            'pages' => $pages,
        ];

        return view('admin.questionnaire.page.list', $data);
    }

    public function getNew()
    {
        $data = [
            'active' => 'questionnaire',
            'pageWithForm' => true,
        ];

        return view('admin.questionnaire.page.new', $data);
    }

    public function postNew(Request $request)
    {
        $rules = [
            'label' => 'required|min:2',
        ];
        $request->validate($rules);

        $page = new QuestionnairePage;

        if (App::isLocale('sv')) {
            $page->label_sv = $request->get('label');
            $page->description_sv = $request->get('description');
        } elseif (App::isLocale('en')) {
            $page->label_en = $request->get('label');
            $page->description_en = $request->get('description');
        }

        if ($request->has('show_description')) {
            $page->show_description = true;
        } else {
            $page->show_description = false;
        }

        $page->save();

        return redirect()->action('QuestionnairePageController@getList');
    }

    public function getEdit($id)
    {
        $page = QuestionnairePage::find($id);

        $data = [
            'active' => 'questionnaire',
            'id' => $id,
            'label' => $page->t_label(),
            'description' => $page->t_description(),
            'show_description' => $page->show_description,
            'pageWithForm' => true,
        ];

        return view('admin.questionnaire.page.edit', $data);
    }

    public function postEdit(Request $request, $id)
    {
        $rules = [
            'label' => 'required|min:2',
        ];
        $request->validate($rules);

        $page = QuestionnairePage::find($id);

        if (App::isLocale('sv')) {
            $page->label_sv = $request->get('label');
            $page->description_sv = $request->get('description');
        } elseif (App::isLocale('en')) {
            $page->label_en = $request->get('label');
            $page->description_en = $request->get('description');
        }

        if ($request->has('show_description')) {
            $page->show_description = true;
        } else {
            $page->show_description = false;
        }

        $page->save();

        return redirect()->action('QuestionnairePageController@getList');
    }

    public function getDelete($id)
    {
        $page = QuestionnairePage::findOrFail($id);

        $data = [
            'id' => $id,
            'name' => $page->t_label(),
        ];

        return view('admin.questionnaire.page.delete', $data);
    }

    public function postDelete($id)
    {
        $page = QuestionnairePage::findOrFail($id);
        $page->delete();

        return redirect()->action('QuestionnairePageController@getList');
    }
}
