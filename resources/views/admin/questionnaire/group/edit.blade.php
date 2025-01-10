@extends('user-layout-without-panel')

@section('styles')
    <style>
        #group-contents {
            width: 900px;
            list-style-type: none;
            /*background: #F4F4F4;*/
            margin-left: 0;
            padding-left: 0;
        }

        #group-contents ul {
            list-style-type: none;
        }

        #group-contents li {
            padding: 10px;
            border: 1px solid #000;
            margin-top: 2px;
            margin-bottom: 2px;
            /*background: #fff;*/
        }

        #group-contents li li {
            border: 1px solid #000;
            width: 750px;
        }

        .group-item-list {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .edit-contents {
            display: none;
        }

        #list-new-item {
            display: block;
        }

        .section {
            display: inline-block;
            vertical-align: top;
            margin-right: 15px;
        }

        .limits {
            display: none;
        }

        textarea {
            color: #000;
        }
    </style>
@stop

@section('title')
Ändra enkätsida
@stop

@section('page-header')
Ändra enkätsida
@stop

@section('content')
    {{ Form::open(array('action' => array("QuestionnaireGroupsController@postEdit", $id), 'class' => 'info-form edit-questionnaire-group-form')) }}

    @if (!$errors->isEmpty())
    <p class="errors">
        {{ $errors->first('label')}}
    </p>
    @endif
    {{ Form::label('label', 'Namn *') }}<br>
    {{ Form::text('label', $group->t_label()) }}<br>

    <label for="hide_label">Göm namn i enkäten</label><br>
    <select name="hide_label" id="hide_label">
        <option value="0" @selected(!$group->hide_label)>Nej</option>
        <option value="1" @selected($group->hide_label)>Ja</option>
    </select><br>

    <input type="hidden" id="removed" name="removed">

    <h2>Innehåll</h2>
    <ul id="group-contents">
        <li>
        @if ($group->type->name === "list")
            <h4>{{ t("elements.list-objects") }}</h4>
            <ul id="item-list">
                @foreach ($group->questions as $i => $question)
                    <?php
                    $typeName = $question->type->template_name;
                    $json = json_decode($question->data, true);
                    if (isset($json['count'])) {
                        $name = $typeName . '-' . $json['count'] . '-' . ($i + 1);
                    } else {
                        $name = $typeName . '-' . ($i + 1);
                    }
                    $risk = isset($risks[$question->form_name]) ? $risks[$question->form_name] : array(0 => 3, 1 => 3);
                    if (!isset($json['labels'])) {
                        $locale = App::isLocale('sv') ? 'sv' : 'en';
                        if (isset($json['labels_' . $locale])) {
                            $json['labels'] = $json['labels_' . $locale];
                        }
                    }
                    $data = [
                        'name' => $name,
                        'label' => $question->t_label(),
                        'form_name' => $question->form_name,
                        'description' => $question->t_description(),
                        'has_help' => $question->has_help,
                        'help' => $question->t_help(),
                        'subquestion' => $question->is_subquestion,
                        'has_sub' => $question->has_subquestion,
                        'video_id' => $question->video_id,
                    ];
                    ?>
                    <li>
                        <div>
                            <span>{{ t("general.question") }}: <span class="question-handle">{{ $question->t_label() }}</span></span>
                            <a class="edit-question" href=""><i class="fa fa-pencil-square"></i></a>
                            <a class="remove-question" href=""><i class="fa fa-trash"></i></a>
                            <div class="edit-contents">
                                <input type="hidden" class="weight" name="items[{{ $name }}][weight]" value="{{ $question->weight }}">
                                @if ($typeName === "list-item")
                                    <?php
                                    $data = $data + array(
                                        'items' => $json['items'],
                                        'labels' => $json['labels'],
                                        'count' => $json['count'],
                                        'category_id' => $question->category_id,
                                        'is_part_of_conditional' => $question->is_part_of_conditional,
                                        'is_conditional' => $question->is_conditional,
                                        'factors' => $factors,
                                        'toggle_value' => isset($json['toggle_value']) ? $json['toggle_value'] : 1
                                    );
                                    ?>
                                    @if ($json['count'] == 2)
                                    <?php $data['is_conditional'] = $question->is_conditional; ?>
                                    @include("questionnaire.edit-templates.list-item-2-c", $data)
                                    @else
                                    @include("questionnaire.edit-templates.list-item-c", $data)
                                    @endif
                                @elseif ($typeName === "list-text")
                                    <?php
                                    $data = $data + array(
                                        'category_id' => $question->category_id,
                                        'is_part_of_conditional' => $question->is_part_of_conditional,
                                        'factors' => $factors,
                                    );
                                    ?>
                                    @include("questionnaire.edit-templates.list-text-c", $data)
                                @elseif ($typeName === "list-text-node")
                                    @include("questionnaire.edit-templates.list-text-node-c", $data)
                                @endif
                            </div>
                        </div>
                    </li>
                    <?php $i += 1; ?>
                @endforeach
            </ul>
            <label for="list-type">{{ t("elements.list-type") }}</label>
            <select id="list-type" name="list-type">
                <option value="5">{{ t("elements.list-5") }}</option>
                <option value="7">{{ t("elements.list-7") }}</option>
                <option value="2">{{ t("elements.list-2") }}</option>
                <option value="text">{{ t("elements.list-text") }}</option>
                <option value="text-node">{{ t("elements.list-text-node") }}</option>
            </select>
            <button id="list-new-item" class="btn" type="button">{{ t("elements.list-new-item") }}</button>
        @elseif ($group->type->name === "form-group")
            <h4>{{ t("elements.list-objects") }}</h4>
            <ul id="item-list">
                @foreach ($group->questions as $i => $question)
                <?php
                $typeName = $question->type->template_name;
                $json = json_decode($question->data, true);
                $risk = isset($risks[$question->form_name]) ? $risks[$question->form_name] : array(0 => 1, 1 => 1);
                if (!isset($json['labels'])) {
                    $locale = App::isLocale('sv') ? 'sv' : 'en';
                    if (isset($json['labels_' . $locale])) {
                        $json['labels'] = $json['labels_' . $locale];
                    }
                }
                ?>
                <li>
                    <div>
                        <span>{{ t("general.question") }}: <span class="question-handle">{{ $question->t_label() }}</span></span>
                        <a class="edit-question" href=""><i class="fa fa-pencil-square"></i></a>
                        <a class="remove-question" href=""><i class="fa fa-trash"></i></a>
                        <div class="edit-contents">
                            @php
                            $data = array(
                                'name' => $typeName . '-' . ($i + 1),
                                'label' => $question->t_label(),
                                'form_name' => $question->form_name,
                                'description' => $question->t_description(),
                                'has_help' => $question->has_help,
                                'help' => $question->t_help(),
                                'video_id' => $question->video_id,
                                'subquestion' => $question->is_subquestion,
                                'category_id' => $question->category_id,
                                'has_sub' => $question->has_subquestion,
                                'factors' => $factors,
                            );
                            @endphp
                            <input type="hidden" class="weight" name="items[{{ $typeName . '-' . ($i + 1) }}][weight]" value="{{ $question->weight }}">
                            @if ($typeName === "form-textbox")
                                <?php
                                $data['limits'] = isset($limits[$question->form_name]) ? $limits[$question->form_name] : null;
                                $data['suffix'] = isset($json['suffix']) ? $json['suffix'] : "";
                                ?>
                                {!! View::make("questionnaire.edit-templates.form-textbox-c", $data) !!}
                            @elseif ($typeName === "form-radio")
                                <?php
                                $data['items'] = $json['items'];
                                $data['min'] = $json['min'];
                                $data['max'] = $json['max'];
                                ?>
                                {!! View::make("questionnaire.edit-templates.form-radio-c", $data) !!}
                            @elseif ($typeName === "form-joint")
                                {!! View::make("questionnaire.edit-templates.form-joint-c", $data) !!}
                            @elseif ($typeName === "form-estimation")
                                <?php
                                $data['labels'] = $json['labels'];
                                ?>
                                {!! View::make("questionnaire.edit-templates.form-estimation-c", $data) !!}
                            @elseif ($typeName === "form-bmi")
                                {!! View::make("questionnaire.edit-templates.form-bmi-c", $data) !!}
                            @elseif ($typeName === "form-twovalues")
                                <?php
                                $data['form_name'] = explode(",", $data['form_name']);
                                $data['suffix'] = isset($json['suffix']) ? $json['suffix'] : "";
                                ?>
                                {!! View::make("questionnaire.edit-templates.form-twovalues-c", $data) !!}
                            @elseif ($typeName === "form-mfr")
                                {!! View::make("questionnaire.edit-templates.form-mfr-c", $data) !!}
                            @elseif ($typeName === "form-arm-method")
                                {!! View::make("questionnaire.edit-templates.form-arm-method-c", $data) !!}
                            @elseif ($typeName === "form-fit-method")
                                {!! View::make("questionnaire.edit-templates.form-fit-method-c", $data) !!}
                            @elseif ($typeName === "form-fitness-step")
                                {!! View::make("questionnaire.edit-templates.form-fitness-c", $data) !!}
                            @elseif ($typeName === "form-fitness-bicycle")
                                {!! View::make("questionnaire.edit-templates.form-fitness-c", $data) !!}
                            @elseif ($typeName === "form-fitness-walk")
                                {!! View::make("questionnaire.edit-templates.form-fitness-c", $data) !!}
                            @elseif ($typeName === "form-fitness-mlo2")
                                {!! View::make("questionnaire.edit-templates.form-fitness-c", $data) !!}
                            @elseif ($typeName === "form-fitness-lo2")
                                {!! View::make("questionnaire.edit-templates.form-fitness-c", $data) !!}
                            @elseif ($typeName === "form-fitness-beep")
                                {!! View::make("questionnaire.edit-templates.form-fitness-c", $data) !!}
                            @elseif ($typeName === "form-fitness-cooper")
                                {!! View::make("questionnaire.edit-templates.form-fitness-c", $data) !!}
                            @elseif ($typeName === "form-text-node")
                                {!! View::make("questionnaire.edit-templates.form-text-node-c", $data) !!}
                            @elseif ($typeName === "form-energy-needs")
                                {!! View::make("questionnaire.edit-templates.form-energy-needs-c", $data) !!}
                            @elseif ($typeName === "form-energy-intake")
                                {!! View::make("questionnaire.edit-templates.form-energy-intake-c", $data) !!}
                            @elseif ($typeName === "form-energy-balance")
                                {!! View::make("questionnaire.edit-templates.form-energy-balance-c", $data) !!}
                            @endif
                        </div>
                    </div>
                </li>
                <?php $i += 1; ?>
                @endforeach
            </ul>
            <select id="item-list-select">
                <?php $types = json_decode($formTypes, true); ?>
                @foreach ($types as $type => $label)
                    @if (!Str::contains($type, "list"))
                    <option value="{{ $type }}">{{ t($label) }}</option>
                    @endif
                @endforeach
            </select>
            <button type="button" class="btn" id="item-list-new-item">{{ t("elements.group-new-item") }}</button>
        @endif
        </li>
    </ul>

    <br>

    {{ Form::submit('Spara ändringar', array("class" => "btn")) }} <a href="{{ url('/admin/questionnaire/pages') }}" class="back-link">Avbryt</a>

    {{ Form::close() }}

    <script>
        $(document).ready(function()
        {
            $(".edit-question").click(editQuestion);
            $(".remove-question").click(removeQuestion);

            $("#list-new-item").click(createListQuestion);
            $("#item-list-new-item").click(createFormQuestion);

            hookupKeyup();

            reinitQuestionSorting();
        });

        function reinitQuestionSorting()
        {
            $("#item-list").sortable({
                stop: function(event, ui) {
                    $("#item-list li").each(function(idx, elem)
                    {
                        $(elem).find(".weight").val(idx);
                    });
                }
            });
        }

        function hookupKeyup()
        {
            $(".question-label").each(setupTitleChanging);
        }

        function setupTitleChanging(idx, e)
        {
            $(e).keyup(function()
            {
                var elem = $(this).parent().parent().find('.question-handle');
                elem.text($(this).val());
            });
        }

        function editQuestion()
        {
            $(this).parent().find('.edit-contents').toggle();
            return false;
        }

        function removeQuestion()
        {
            if (confirm("<?php echo t('general.confirm-delete-question') ?>"))
            {
                var removed = $("#removed");
                var existing = $(this).parent().find('.form_name');
                if (existing.size() > 0)
                {
                    var name = "";
                    if (existing.size() === 1)
                    {
                        name = existing.val();
                    }
                    else
                    {
                        for (let i = 0; i < existing.size(); i++) {
                            name += existing[i].value;
                            name += ",";
                        }

                        name = name.substring(0, name.length - 1);
                    }

                    if (removed.val() === "")
                        removed.val(name);
                    else
                        removed.val(removed.val() + "|" + name);
                }
                $(this).parent().parent().remove();
            }
            return false;
        }

        function createHandle()
        {
            var handle = $(document.createElement('div'));
            handle.html('<span><?php echo t("general.question") . ": <span class=\"question-handle\">" . t("general.new-question") ?></span></span> ');
            var editLink = $(document.createElement('a'));
            editLink.attr('href', '');
            editLink.text('<?php echo t("general.edit") ?>');
            editLink.click(editQuestion);
            handle.append(editLink);

            var space = $(document.createTextNode(' '));
            handle.append(space);

            var removeLink = $(document.createElement('a'));
            removeLink.attr('href', '');
            removeLink.text('<?php echo t("general.remove") ?>');
            removeLink.click(removeQuestion);
            handle.append(removeLink);

            return handle;
        }

        function createListQuestion()
        {
            var elem = $("#item-list");
            var type = $("#list-type").find(":selected").val();

            var count = $("#item-list li").size() + 1;

            var li = createListItem();

            var handle = createHandle();

            var editContents = $(document.createElement('div'));
            editContents.addClass('edit-contents');

            var name = "list-item-" + type +  "-" + count;
            if (type === "5")
            {
                var value = "@include('questionnaire.edit-templates.list-item', array('factors' => $factors, 'count' => 5))";
            }
            else if (type === "7")
            {
                var value = "@include('questionnaire.edit-templates.list-item', array('factors' => $factors, 'count' => 7))";
            }
            else if (type === "2")
            {
                var value = "@include('questionnaire.edit-templates.list-item-2', array('factors' => $factors, 'count' => 2))";
            }
            else if (type === "text")
            {
                var value = "@include('questionnaire.edit-templates.list-text', array('factors' => $factors))";
                name = "list-" + type + "-" + count;
            }
            else if (type === "text-node")
            {
                var value = "<?php echo view('questionnaire.edit-templates.list-text-node') ?>";
                name = "list-" + type + "-" + count;
            }

            editContents.html(value.replace(/#name/g, name));
            editContents.find(".weight").val(count - 1);
            handle.append(editContents);

            li.append(handle);

            elem.append(li);

            reinitQuestionSorting();

            hookupKeyup();
        }

        function createListItem()
        {
            return $(document.createElement('li'));
        }

        function createGroupTypeSelect(root)
        {
            var types = JSON.parse('<?php echo $formTypes; ?>');

            var select = $(document.createElement('select'));
            select.attr({ "id": root.attr("id") + "-select" });

            for (type in types)
            {
                if (type.indexOf("list") > -1)
                    continue;

                var option = $(document.createElement('option'));
                option.attr({ "value": type });
                option.text(types[type]);
                select.append(option);
            }

            root.append(select);
        }

        function createFormQuestion()
        {
            var elem = $("#item-list");
            var type = $("#item-list-select").find(':selected').val();
            var count = $("#item-list li").size() + 1;

            var li = createListItem();

            var handle = createHandle();

            var editContents = $(document.createElement('div'));
            editContents.addClass('edit-contents');

            if (type === "form-textbox")
            {
                var name = "form-textbox-" + count;

                var value = "@include('questionnaire.edit-templates.form-textbox', array('factors' => $factors))";
            }
            else if (type === "form-radio")
            {
                var name = "form-radio-" + count;

                var value = "@include('questionnaire.edit-templates.form-radio', array('factors' => $factors))";
            }
            else if (type === "form-joint")
            {
                var name = "form-joint-" + count;

                var value = "@include('questionnaire.edit-templates.form-joint', array('factors' => $factors))";
            }
            else if (type === "form-estimation")
            {
                var name = "form-estimation-" + count;

                var value = "@include('questionnaire.edit-templates.form-estimation', array('factors' => $factors))";
            }
            else if (type === "form-bmi")
            {
                var name = "form-bmi-" + count;

                var value = "@include('questionnaire.edit-templates.form-bmi', array('factors' => $factors))";
            }
            else if (type === "form-twovalues")
            {
                var name = "form-twovalues-" + count;

                var value = "@include('questionnaire.edit-templates.form-twovalues', array('factors' => $factors))";
            }
            else if (type === "form-mfr")
            {
                var name = "form-mfr-" + count;

                var value = "@include('questionnaire.edit-templates.form-mfr', array('factors' => $factors))";
            }
            else if (type === "form-arm-method")
            {
                var name = "form-arm-method-" + count;

                var value = "@include('questionnaire.edit-templates.form-arm-method', array('factors' => $factors))";
            }
            else if (type === "form-fit-method")
            {
                var name = "form-fit-method-" + count;

                var value = "@include('questionnaire.edit-templates.form-fit-method', array('factors' => $factors))";
            }
            else if (type === "form-fitness-step" ||
                     type === "form-fitness-bicycle" ||
                     type === "form-fitness-walk" ||
                     type === "form-fitness-mlo2" ||
                     type === "form-fitness-lo2" ||
                     type === "form-fitness-beep" ||
                     type === "form-fitness-cooper")
            {
                switch (type)
                {
                    case "form-fitness-step":
                        var name = "form-fitness-step-" + count;
                        break;
                    case "form-fitness-bicycle":
                        var name = "form-fitness-bicycle-" + count;
                        break;
                    case "form-fitness-walk":
                        var name = "form-fitness-walk-" + count;
                        break;
                    case "form-fitness-mlo2":
                        var name = "form-fitness-mlo2-" + count;
                        break;
                    case "form-fitness-lo2":
                        var name = "form-fitness-lo2-" + count;
                        break;
                    case "form-fitness-beep":
                        var name = "form-fitness-beep-" + count;
                    case "form-fitness-cooper":
                        var name = "form-fitness-cooper-" + count;
                        break;
                }

                var value = "@include('questionnaire.edit-templates.form-fitness', array('factors' => $factors))";
            }
            else if (type === "form-text-node")
            {
                var name = "form-text-node-" + count

                var value = "<?= View::make('questionnaire.edit-templates.form-text-node'); ?>";
            }
            else if (type === "form-energy-needs")
            {
                var name = "form-energy-needs-" + count;

                var value = "@include('questionnaire.edit-templates.form-energy-needs', array('factors' => $factors))";
            }
            else if (type === "form-energy-intake")
            {
                var name = "form-energy-intake-" + count;

                var value = "@include('questionnaire.edit-templates.form-energy-intake', array('factors' => $factors))";
            }
            else if (type === "form-energy-balance")
            {
                var name = "form-energy-balance-" + count;

                var value = "@include('questionnaire.edit-templates.form-energy-balance', array('factors' => $factors))";
            }
            else
            {
                return;
            }

            editContents.html(value.replace(/#name/g, name));
            editContents.find(".weight").val(count - 1);
            handle.append(editContents);

            li.append(handle);

            elem.append(li);

            reinitQuestionSorting();
        }
    </script>
@stop