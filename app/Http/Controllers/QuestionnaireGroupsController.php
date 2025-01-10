<?php

namespace App\Http\Controllers;

use App\ElementType;
use App\GroupType;
use App\ProfileValue;
use App\QuestionnaireCategory;
use App\QuestionnaireGroup;
use App\QuestionnairePage;
use App\QuestionnaireQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class QuestionnaireGroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.super');
    }

    public function getNew($id)
    {
        QuestionnairePage::findOrFail($id);
        $groupTypes = [];
        foreach (GroupType::all() as $type) {
            $groupTypes[$type->id] = t($type->label);
        }

        $data = [
            'active' => 'questionnaire',
            'groupTypes' => $groupTypes,
            'page_id' => $id,
            'pageWithForm' => true,
        ];

        return view('admin.questionnaire.group.new', $data);
    }

    public function postNew(Request $request, $id)
    {
        QuestionnairePage::findOrFail($id);

        $rules = [
            'label' => 'required|min:2',
        ];
        $request->validate($rules);

        $group = new QuestionnaireGroup;

        if (App::isLocale('sv')) {
            $group->label_sv = $request->get('label');
        } elseif (App::isLocale('en')) {
            $group->label_en = $request->get('label');
        }

        $group->page_id = $id;
        $group->type_id = $request->get('type');

        $group->save();

        return redirect()->action('QuestionnairePageController@getList');
    }

    public function getEdit($id)
    {
        $group = QuestionnaireGroup::findOrFail($id);

        $formTypes = [];
        foreach (ElementType::all() as $type) {
            $formTypes[$type->template_name] = t($type->label);
        }

        $factors = [];
        foreach (QuestionnaireCategory::all() as $factor) {
            $factors[$factor->id] = $factor->label;
        }

        uasort($factors, fn ($a, $b) => t($a) <=> t($b));

        $data = [
            'active' => 'questionnaire',
            'id' => $id,
            'group' => $group,
            'formTypes' => json_encode($formTypes),
            'factors' => $factors,
            'pageWithForm' => true,
        ];

        return view('admin.questionnaire.group.edit', $data);
    }

    public function createQuestion($data, $type)
    {
        $question = new QuestionnaireQuestion;

        $question->type_id = $type;

        if (App::isLocale('sv')) {
            $question->label_sv = $data['label'];
            $question->description_sv = $data['description'];
            $question->help_sv = $data['help'];
        } elseif (App::isLocale('en')) {
            $question->label_en = $data['label'];
            $question->description_en = $data['description'];
            $question->help_en = $data['help'];
        }

        $question->form_name = $data['form_name'];

        $question->has_help = isset($data['has_help']);

        if (isset($data['video_id'])) {
            $question->video_id = $data['video_id'] ?: null;
        }

        return $question;
    }

    public function editQuestion($question, $data)
    {
        if (App::isLocale('sv')) {
            $question->label_sv = $data['label'];
            $question->description_sv = $data['description'];
            $question->help_sv = $data['help'];
        } elseif (App::isLocale('en')) {
            $question->label_en = $data['label'];
            $question->description_en = $data['description'];
            $question->help_en = $data['help'];
        }

        $question->form_name = $data['form_name'];

        $question->has_help = isset($data['has_help']);

        if (isset($data['video_id'])) {
            $question->video_id = $data['video_id'] ?: null;
        }

        return $question;
    }

    public function createTextbox($data)
    {
        $question = $this->createQuestion($data, 1);

        $json = [
            'suffix' => $data['suffix'],
        ];

        $question->data = json_encode($json);

        return $question;
    }

    public function editTextbox($question, $data)
    {
        $question = $this->editQuestion($question, $data);

        $json = [
            'suffix' => $data['suffix'],
        ];

        $question->data = json_encode($json);

        return $question;
    }

    public function createRadio($data)
    {
        $question = $this->createQuestion($data, 2);

        $json = [
            'items' => [],
        ];
        foreach ($data['items'] as $item) {
            $json['items'][] = $item;
        }
        $json['min'] = $data['min'];
        $json['max'] = $data['max'];

        $question->data = json_encode($json);

        return $question;
    }

    public function editRadio($question, $data)
    {
        $question = $this->editQuestion($question, $data);

        $json = ['items' => []];
        foreach ($data['items'] as $item) {
            $json['items'][] = $item;
        }
        $json['min'] = $data['min'];
        $json['max'] = $data['max'];

        $question->data = json_encode($json);

        return $question;
    }

    public function createListItem($data)
    {
        $question = $this->createQuestion($data, 3);

        $question->is_conditional = isset($data['is_conditional']);
        $question->is_part_of_conditional = isset($data['is_part_of_conditional']);

        if (isset($data['items'])) {
            $count = count($data['items']);

            $json = [
                'items' => [],
                'labels_sv' => [],
                'labels_en' => [],
            ];
            for ($i = 0; $i < $count; ++$i) {
                $json['items'][] = $data['items'][$i];

                if (App::isLocale('sv')) {
                    $json['labels_sv'][] = $data['labels'][$i];
                    $json['labels_en'][] = $data['labels'][$i];
                } elseif (App::isLocale('en')) {
                    $json['labels_sv'][] = $data['labels'][$i];
                    $json['labels_en'][] = $data['labels'][$i];
                }
            }

            $json['count'] = $count;
        } else {
            $json = [];
        }

        $question->data = json_encode($json);

        return $question;
    }

    public function editListItem($question, $data)
    {
        $question = $this->editQuestion($question, $data);

        $question->is_conditional = isset($data['is_conditional']);
        $question->is_part_of_conditional = isset($data['is_part_of_conditional']);

        $count = count($data['items']);

        $old_data = json_decode($question->data, true);

        $json = [
            'items' => [],
            'labels_sv' => [],
            'labels_en' => [],
        ];
        for ($i = 0; $i < $count; ++$i) {
            $json['items'][] = $data['items'][$i];

            if (App::isLocale('sv')) {
                $json['labels_sv'][] = $data['labels'][$i];
                if (isset($old_data['labels_en'][$i])) {
                    $json['labels_en'][] = $old_data['labels_en'][$i];
                } else {
                    $json['labels_en'][] = $data['labels'][$i];
                }
            } elseif (App::isLocale('en')) {
                $json['labels_en'][] = $data['labels'][$i];
                if (isset($old_data['labels_sv'][$i])) {
                    $json['labels_sv'][] = $old_data['labels_sv'][$i];
                } else {
                    $json['labels_sv'][] = $data['labels'][$i];
                }
            }
        }

        $json['count'] = $count;

        if (isset($data['toggle_value'])) {
            $json['toggle_value'] = $data['toggle_value'];
        }

        $question->data = json_encode($json);

        return $question;
    }

    public function createJoint($data)
    {
        return $this->createQuestion($data, 4);
    }

    public function editJoint($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createEstimation($data)
    {
        $question = $this->createQuestion($data, 5);

        $json = [
            'labels_sv' => [],
            'labels_en' => [],
        ];
        for ($i = 0; $i < 3; ++$i) {
            if (App::isLocale('sv')) {
                $json['labels_sv'][] = $data['labels'][$i];
                $json['labels_en'][] = '';
            } elseif (App::isLocale('en')) {
                $json['labels_sv'][] = '';
                $json['labels_en'][] = $data['labels'][$i];
            }
        }

        $question->data = json_encode($json);

        return $question;
    }

    public function editEstimation($question, $data)
    {
        $question = $this->editQuestion($question, $data);

        $old_data = json_decode($question->data, true);

        $json = [
            'labels_sv' => [],
            'labels_en' => [],
        ];
        for ($i = 0; $i < 3; ++$i) {
            if (App::isLocale('sv')) {
                $json['labels_sv'][] = $data['labels'][$i];
                if (isset($old_data['labels_en'][$i])) {
                    $json['labels_en'][] = $old_data['labels_en'][$i];
                } else {
                    $json['labels_en'][] = '';
                }
            } elseif (App::isLocale('en')) {
                $json['labels_en'][] = $data['labels'][$i];
                if (isset($old_data['labels_sv'][$i])) {
                    $json['labels_sv'][] = $old_data['labels_sv'][$i];
                } else {
                    $json['labels_sv'][] = '';
                }
            }
        }

        $question->data = json_encode($json);

        return $question;
    }

    public function createBMI($data)
    {
        return $this->createQuestion($data, 6);
    }

    public function editBMI($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createTwoValues($data)
    {
        $question = $this->createQuestion($data, 7);
        $json = ['suffix' => $data['suffix']];
        $question->data = json_encode($json);

        return $question;
    }

    public function editTwoValues($question, $data)
    {
        $question = $this->editQuestion($question, $data);
        $json = ['suffix' => $data['suffix']];
        $question->data = json_encode($json);

        return $question;
    }

    public function createMFR($data)
    {
        return $this->createQuestion($data, 8);
    }

    public function editMFR($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createArmMethod($data)
    {
        return $this->createQuestion($data, 19);
    }

    public function editArmMethod($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createFitMethod($data)
    {
        return $this->createQuestion($data, 9);
    }

    public function editFitMethod($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createStep($data)
    {
        return $this->createQuestion($data, 10);
    }

    public function editStep($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createBicycle($data)
    {
        return $this->createQuestion($data, 11);
    }

    public function editBicycle($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createWalk($data)
    {
        return $this->createQuestion($data, 12);
    }

    public function editWalk($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createMlo2($data)
    {
        return $this->createQuestion($data, 13);
    }

    public function editMlo2($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createLo2($data)
    {
        return $this->createQuestion($data, 14);
    }

    public function editLo2($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createBeep($data)
    {
        return $this->createQuestion($data, 18);
    }

    public function editBeep($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createCooper($data)
    {
        return $this->createQuestion($data, 20);
    }

    public function editCooper($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createEnergyNeeds($data)
    {
        return $this->createQuestion($data, 21);
    }

    public function editEnergyNeeds($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createEnergyIntake($data)
    {
        return $this->createQuestion($data, 22);
    }

    public function editEnergyIntake($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createEnergyBalance($data)
    {
        return $this->createQuestion($data, 23);
    }

    public function editEnergyBalance($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createListText($data)
    {
        $question = $this->createQuestion($data, 15);
        $question->is_part_of_conditional = isset($data['is_part_of_conditional']);
        $question->data = json_encode([]);

        return $question;
    }

    public function editListText($question, $data)
    {
        $question = $this->editQuestion($question, $data);
        $question->is_part_of_conditional = isset($data['is_part_of_conditional']);

        return $question;
    }

    public function createListTextNode($data)
    {
        return $this->createQuestion($data, 16);
    }

    public function editListTextNode($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    public function createFormTextNode($data)
    {
        return $this->createQuestion($data, 17);
    }

    public function editFormTextNode($question, $data)
    {
        return $this->editQuestion($question, $data);
    }

    private $functions = [
        'list-text-node' => ['create' => 'createListTextNode', 'edit' => 'editListTextNode'],
        'form-text-node' => ['create' => 'createFormTextNode', 'edit' => 'editFormTextNode'],
        'estimation' => ['create' => 'createEstimation', 'edit' => 'editEstimation'],
        'twovalues' => ['create' => 'createTwoValues', 'edit' => 'editTwoValues'],
        'list-item' => ['create' => 'createListItem', 'edit' => 'editListItem'],
        'list-text' => ['create' => 'createListText', 'edit' => 'editListText'],
        'textbox' => ['create' => 'createTextbox', 'edit' => 'editTextbox'],
        'bicycle' => ['create' => 'createBicycle', 'edit' => 'editBicycle'],
        'arm-method' => ['create' => 'createArmMethod', 'edit' => 'editArmMethod'],
        'fit-method' => ['create' => 'createFitMethod', 'edit' => 'editFitMethod'],
        'joint' => ['create' => 'createJoint', 'edit' => 'editJoint'],
        'radio' => ['create' => 'createRadio', 'edit' => 'editRadio'],
        'walk' => ['create' => 'createWalk', 'edit' => 'editWalk'],
        'mlo2' => ['create' => 'createMlo2', 'edit' => 'editMlo2'],
        'step' => ['create' => 'createStep', 'edit' => 'editStep'],
        'bmi' => ['create' => 'createBMI', 'edit' => 'editBMI'],
        'mfr' => ['create' => 'createMFR', 'edit' => 'editMFR'],
        'lo2' => ['create' => 'createLo2', 'edit' => 'editLo2'],
        'beep' => ['create' => 'createBeep', 'edit' => 'editBeep'],
        'cooper' => ['create' => 'createCooper', 'edit' => 'editCooper'],
        'energy-needs' => ['create' => 'createEnergyNeeds', 'edit' => 'editEnergyNeeds'],
        'energy-intake' => ['create' => 'createEnergyIntake', 'edit' => 'editEnergyIntake'],
        'energy-balance' => ['create' => 'createEnergyBalance', 'edit' => 'editEnergyBalance'],
    ];

    private function parseQuestionInput($exists, $key, $value, $group)
    {
        $question = $exists;
        foreach ($this->functions as $funckey => $func) {
            if (Str::contains($key, $funckey)) {
                if (is_null($exists)) {
                    $question = $this->{$func['create']}($value);
                    $question->group_id = $group->id;
                } else {
                    $question = $this->{$func['edit']}($exists, $value);
                }

                break;
            }
        }

        $question->is_subquestion = isset($value['subquestion']);
        $question->has_subquestion = isset($value['has_sub']);

        if (isset($value['factor'])) {
            $factor = intval($value['factor']);
            if ($factor > 0) {
                $question->category_id = $value['factor'];
            } else {
                $question->category_id = null;
            }
        }

        $question->weight = $value['weight'];

        $question->save();
    }

    public function postEdit(Request $request, $id)
    {
        $request->validate([
            'label' => 'required|min:2',
        ]);

        $group = QuestionnaireGroup::findOrFail($id);

        if (App::isLocale('sv')) {
            $group->label_sv = $request->get('label');
        } elseif (App::isLocale('en')) {
            $group->label_en = $request->get('label');
        }

        $group->hide_label = $request->get('hide_label');

        $group->save();

        if ($request->has('items')) {
            foreach ($request->get('items') as $key => $value) {
                if (! isset($value['form_name'])) {
                    continue;
                }
                if (is_array($value['form_name'])) {
                    $old = implode(',', $value['old_form_name']);
                    $new = implode(',', $value['form_name']);
                    $value['form_name'] = $new;
                } else {
                    $old = $value['old_form_name'];
                    $new = $value['form_name'];
                }

                $exists = QuestionnaireQuestion::where('form_name', $old)->first();
                $this->parseQuestionInput($exists, $key, $value, $group);

                if ($new !== $old) {
                    if (is_array($value['old_form_name'])) {
                        foreach ($value['old_form_name'] as $entry) {
                            foreach (ProfileValue::where('name', $entry) as $profval) {
                                $profval->name = $new;
                                $profval->save();
                            }
                        }
                    } else {
                        foreach (ProfileValue::where('name', $old) as $profval) {
                            $profval->name = $new;
                            $profval->save();
                        }
                    }
                }
            }
        }

        $removed = $request->get('removed') ?? '';
        if ($removed !== '') {
            $removed = explode('|', $removed);
            foreach ($removed as $form_name) {
                if (Str::contains($form_name, ',')) {
                    $parts = explode(',', $form_name);
                    foreach ($parts as $part) {
                        if ($part == 'undefined' || $part == -1 || empty($part)) {
                            continue;
                        }

                        $question = QuestionnaireQuestion::where('form_name', $part)->first();
                        if ($question) {
                            $question->delete();
                        }

                        foreach (ProfileValue::where('name', $form_name) as $value) {
                            $value->delete();
                        }
                    }

                    $question = QuestionnaireQuestion::where('form_name', $form_name)->first();
                    $question->delete();
                } else {
                    $question = QuestionnaireQuestion::where('form_name', $form_name)->first();
                    $question->delete();

                    foreach (ProfileValue::where('name', $form_name) as $value) {
                        $value->delete();
                    }
                }
            }
        }

        return redirect()->action('QuestionnairePageController@getList');
    }

    public function getDelete($id)
    {
        $group = QuestionnaireGroup::findOrFail($id);

        $data = [
            'id' => $id,
            'name' => $group->t_label(),
        ];

        return view('admin.questionnaire.group.delete', $data);
    }

    public function postDelete($id)
    {
        $group = QuestionnaireGroup::findOrFail($id);
        $group->delete();

        return redirect()->action('QuestionnairePageController@getList');
    }
}
