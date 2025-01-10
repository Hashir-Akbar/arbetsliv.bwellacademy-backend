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

    [$suffixA, $suffixB] = explode(',', $suffix . ',');
    [$descriptionA, $descriptionB] = explode(',', $description . ',');
?>
<li class="{{ $class }}"{{ isset($category_id) ? ' data-category-id=' . $category_id : '' }}{{ isset($category_id_n) ? ' data-category-id-n=' . $category_id_n : '' }}{{ isset($form_name) ? ' data-question=' . implode(',', $form_name) : '' }} data-template="form-twovalues">
    <div class="info">
        <span class="title">{!! t($label) !!}</span>
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
        <div>
            <div class="description">{!! t($descriptionA) !!}</div>
            <input type="text" name="{{ $form_name[0] }}" id="{{ $form_name[0] }}" value="{{ $values[$form_name[0]] ?? '' }}" {{ !$editable ? 'disabled="disabled"' : '' }}>
            {!! t($suffixA) !!}
        </div>
        <div style="margin-top: 10px;">
            <div class="description">{!! t($descriptionB) !!}</div>
            <input type="text" name="{{ $form_name[1] }}" id="{{ $form_name[1] }}" value="{{ $values[$form_name[1]] ?? '' }}" {{ !$editable ? 'disabled="disabled"' : '' }}>
            {!! t($suffixB) !!}
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