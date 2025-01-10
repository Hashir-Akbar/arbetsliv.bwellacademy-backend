@if ($has_subquestion)
<li class="parent-question">
@elseif ($is_subquestion)
<li class="subquestion">
@elseif (isset($in_special_group) && $in_special_group)
<li class="special-question">
@else
<li class="question" data-template="form-estimation"{{ isset($category_id) ? ' data-category-id=' . $category_id : '' }}{{ isset($category_id_n) ? ' data-category-id-n=' . $category_id_n : '' }}{{ isset($form_name) ? ' data-question=' . $form_name : '' }}>
@endif
    <div class="info">
        <span class="title">{!! t($label) !!}</span>
        <span class="description">{!! t($description) !!}</span>
    </div>
    @if ($has_help)
        <?php $thelp = t($help); ?>
        @if (!empty($thelp))
        <div class="help-button"></div>
        @else
        <div class="help-button-disabled"></div>
        @endif
    @else
    <div class="help-button-padding"></div>
    @endif
    <div class="elements">
        <div class="radio-5">
            <label for="{{ $form_name }}-high">{!! t($labels[0]) !!}</label><br>
            @if (isset($values[$form_name]) && intval($values[$form_name]) == 1)
                <input type="radio" id="{{ $form_name }}-high" name="{{ $form_name }}" value="1" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked">
            @else
                <input type="radio" id="{{ $form_name }}-high" name="{{ $form_name }}" value="1" {{ !$editable ? 'disabled="disabled"' : '' }}>
            @endif
        </div>


        <div class="radio-5">
            <label for="{{ $form_name }}-low">{!! t($labels[1]) !!}</label><br>
            @if (isset($values[$form_name]) && intval($values[$form_name]) == -1)
                <input type="radio" id="{{ $form_name }}-low" name="{{ $form_name }}" value="-1" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked">
            @else
                <input type="radio" id="{{ $form_name }}-low" name="{{ $form_name }}" value="-1" {{ !$editable ? 'disabled="disabled"' : '' }}>
            @endif
        </div>

        <div class="radio-5">
            <label for="{{ $form_name }}-correct">{!! t($labels[2]) !!}</label><br>
            @if (isset($values[$form_name]) && intval($values[$form_name]) == 0)
                <input type="radio" id="{{ $form_name }}-correct" name="{{ $form_name }}" value="0" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked">
            @else
                <input type="radio" id="{{ $form_name }}-correct" name="{{ $form_name }}" value="0" {{ !$editable ? 'disabled="disabled"' : '' }}>
            @endif
        </div>
        <div class="radio-5">
            <label for="{{ $form_name }}-missing">{!! t("elements.missing") !!}</label><br>
            @if (!isset($values[$form_name]) || $values[$form_name] === '' || $values[$form_name] === NULL )
                <input type="radio" id="{{ $form_name }}-missing" name="{{ $form_name }}" value="" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked">
            @else
                <input type="radio" id="{{ $form_name }}-missing" name="{{ $form_name }}" value="" {{ !$editable ? 'disabled="disabled"' : '' }}>
            @endif
        </div>
        <span class="results"></span>
    </div>
    @if ($has_help)
    <div class="help">
        <div class="help-icon"></div>
        <p>
            {!! t($help) !!}
        </p>
    </div>
    @endif
</li>