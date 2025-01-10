<?php
    if ($has_subquestion) {
        $class = "parent-question";
    } elseif ($is_subquestion) {
        $class = "subquestion";
    } elseif (isset($in_special_group) && $in_special_group) {
        $class = "special-question";
    } else {
        $class = 'question';
    }
?>
<li class="{{ $class }}"{{ isset($category_id) ? ' data-category-id=' . $category_id : '' }}{{ isset($category_id_n) ? ' data-category-id-n=' . $category_id_n : '' }}{{ isset($form_name) ? ' data-question=' . $form_name : '' }} data-template="form-joint">
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
            <label for="{{ $form_name }}-0">{!! t("elements.joint-train") !!}</label><br>
            @if (isset($values[$form_name]) && intval($values[$form_name]) == 0)
                <input type="radio" id="{{ $form_name }}-0" name="{{ $form_name }}" value="0" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked">
            @else
                <input type="radio" id="{{ $form_name }}-0" name="{{ $form_name }}" value="0" {{ !$editable ? 'disabled="disabled"' : '' }}>
            @endif
        </div>
        <div class="radio-5">
            <label for="{{ $form_name }}-1">{!! t("elements.joint-good") !!}</label><br>
            @if (isset($values[$form_name]) && intval($values[$form_name]) == 1)
                <input type="radio" id="{{ $form_name }}-1" name="{{ $form_name }}" value="1" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked">
            @else
                <input type="radio" id="{{ $form_name }}-1" name="{{ $form_name }}" value="1" {{ !$editable ? 'disabled="disabled"' : '' }}>
            @endif
        </div>
        <div class="radio-5">
            <label for="{{ $form_name }}-missing">{!! t("elements.missing") !!}</label><br>
            @if (!isset($values[$form_name]) || intval($values[$form_name]) == -1)
                <input type="radio" id="{{ $form_name }}-missing" name="{{ $form_name }}" value="-1" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked">
            @else
                <input type="radio" id="{{ $form_name }}-missing" name="{{ $form_name }}" value="-1" {{ !$editable ? 'disabled="disabled"' : '' }}>
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