<?php
$classes = "";
if ($is_subquestion) {
    $classes .= "subquestion";
} elseif ($has_subquestion) {
    $classes .= "parent-question";
} elseif (isset($in_special_group) && $in_special_group) {
    $classes .= "special-question";
} else {
    $classes .= "question";
}

if (isset($is_conditional) && $is_conditional) {
    $classes .= " conditional";
} elseif (isset($is_part_of_conditional) && $is_part_of_conditional) {
    $classes .= " conditional-part";
}
?>
@if ($hidden)
<li class="{{ $classes }}" style="display: none">
@else
<li class="{{ $classes }}">
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
        <textarea name="{{ $form_name }}" id="{{ $form_name }}" cols="30" rows="4" {{ !$editable ? 'disabled="disabled"' : '' }}>{{ $values[$form_name] ?? '' }}</textarea>
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