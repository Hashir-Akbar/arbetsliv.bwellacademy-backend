<?php
    if ($has_subquestion && isset($in_special_group) && $in_special_group) {
        $class = "special-parent-question";
    } elseif ($has_subquestion) {
        $class = "parent-question";
    } elseif ($is_subquestion && isset($in_special_group) && $in_special_group) {
        $class = "special-subquestion";
    } elseif ($is_subquestion) {
        $class = "subquestion";
    } elseif (isset($in_special_group) && $in_special_group) {
        $class = "special-question";
    } else {
        $class="question";
    }
?>
<li class="{{ $class }}"{{ isset($category_id) ? ' data-category-id=' . $category_id : '' }}{{ isset($category_id_n) ? ' data-category-id-n=' . $category_id_n : '' }}{{ isset($form_name) ? ' data-question=' . $form_name : '' }}>
    <div class="info">
        <span class="title">
        @if ($label === "")
            &nbsp;
        @else
            {!! t($label) !!}
        @endif
        </span>
        <span class="description">{!! t($description) !!}</span>
    </div>
    @if (isset($has_help) && $has_help)
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
        <input type="text" name="{{ $form_name }}" id="{{ $form_name }}" value="{{ $values[$form_name] ?? '' }}" {!! !$editable ? 'disabled="disabled"' : '' !!}>
        {{ $suffix }}

        @if ($form_name == "strArm" && ($participant->sex == "M" || $mock))
            @php
            if (!isset($values["strArmWeights"])) {
                $values["strArmWeights"] = 5;
            }
            @endphp
            <input type="radio" name="strArmWeights" id="strArmWeights-5" value="5" {!! !$editable ? 'disabled="disabled"' : '' !!} {!! $values["strArmWeights"] == 5 ? 'checked="checked"' : '' !!}>
            <label for="strArmWeights-5">5 kg</label>
            <input type="radio" name="strArmWeights" id="strArmWeights-10" value="10" {!! !$editable ? 'disabled="disabled"' : '' !!} {!! $values["strArmWeights"] == 10 ? 'checked="checked"' : '' !!}>
            <label for="strArmWeights-10">10 kg</label>
        @endif

        @if ($form_name == "pushups" && ($participant->sex == "F" || $mock))
            @php
            if (!isset($values["pushupsType"])) {
                $values["pushupsType"] = 0;
            }
            @endphp
            <input type="radio" name="pushupsType" id="pushupsType-0" value="0" {!! !$editable ? 'disabled="disabled"' : '' !!} {!! $values["pushupsType"] == 0 ? 'checked="checked"' : '' !!}>
            <label for="pushupsType-0">På tå</label>
            <input type="radio" name="pushupsType" id="pushupsType-1" value="1" {!! !$editable ? 'disabled="disabled"' : '' !!} {!! $values["pushupsType"] == 1 ? 'checked="checked"' : '' !!}>
            <label for="pushupsType-1">På knä</label>
        @endif

        <span class="results"></span>
    </div>
    @if (isset($has_help) && $has_help)
    <div class="help">
        <div class="help-icon"></div>
        <p>
            {!! t($help) !!}
        </p>
    </div>
    @endif
</li>
