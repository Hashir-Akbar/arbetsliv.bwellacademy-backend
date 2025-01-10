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
<li class="{{ $classes }}"{{ isset($category_id) ? ' data-category-id=' . $category_id : '' }}{{ isset($category_id_n) ? ' data-category-id-n=' . $category_id_n : '' }}{{ isset($form_name) ? ' data-question=' . $form_name : '' }}{{ $hidden ? ' style="display: none"' : '' }}>
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
        @if ($count == 2)
            <div class="radio-2">
                <label for="{{ $form_name }}-yes">{!! t($labels[1]) !!}</label><br>
                @if (isset($values[$form_name]) && intval($values[$form_name] == 1))
                    <input type="radio" id="{{ $form_name }}-yes" name="{{ $form_name }}" value="1" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked">
                @else
                    <input type="radio" id="{{ $form_name }}-yes" name="{{ $form_name }}" value="1" {{ !$editable ? 'disabled="disabled"' : '' }}>
                @endif
            </div>
            <div class="radio-2">
                <label for="{{ $form_name }}-no">{!! t($labels[0]) !!}</label><br>
                @if (isset($values[$form_name]) && intval($values[$form_name] == 0))
                    <input type="radio" id="{{ $form_name }}-no" name="{{ $form_name }}" value="0" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked">
                @else
                    <input type="radio" id="{{ $form_name }}-no" name="{{ $form_name }}" value="0" {{ !$editable ? 'disabled="disabled"' : '' }}>
                @endif
            </div>
            <div class="radio-2">
                <label for="{{ $form_name }}-none">{!! t("elements.missing") !!}</label><br>
                @if (!isset($values[$form_name]) || intval($values[$form_name] == -1))
                    <input type="radio" id="{{ $form_name }}-no" name="{{ $form_name }}" value="-1" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked">
                @else
                    <input type="radio" id="{{ $form_name }}-no" name="{{ $form_name }}" value="-1" {{ !$editable ? 'disabled="disabled"' : '' }}>
                @endif
            </div>
        @elseif ($count == 5)
            @for ($i = 0; $i < 5; $i++)
                @if(!empty($labels[$i]))
                <div class="radio-5">
                    <label for="{{ $form_name }}-{{ $i + 1 }}">{!! t($labels[$i]) !!}</label><br>
                    @if (isset($values[$form_name]) && intval($values[$form_name]) == $items[$i])
                        <input type="radio" id="{{ $form_name }}-{{ $i + 1 }}" name="{{ $form_name }}" value="{{ $items[$i] }}" data-toggle="{{ isset($toggle_value) ? $toggle_value : 1 }}" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked">
                    @else
                        <input type="radio" id="{{ $form_name }}-{{ $i + 1 }}" name="{{ $form_name }}" value="{{ $items[$i] }}" data-toggle="{{ isset($toggle_value) ? $toggle_value : 1 }}" {{ !$editable ? 'disabled="disabled"' : '' }}>
                    @endif
                </div>
                @endif
            @endfor
            <div class="radio-5 last">
                <label for="{{ $form_name }}-0">{!! t("elements.missing") !!}</label><br>
                @if (!isset($values[$form_name]) || intval($values[$form_name]) == 0)
                    <input type="radio" id="{{ $form_name }}-0" name="{{ $form_name }}" value="0" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked">
                @else
                    <input type="radio" id="{{ $form_name }}-0" name="{{ $form_name }}" value="0" {{ !$editable ? 'disabled="disabled"' : '' }}>
                @endif
            </div>
        @else
            <div class="labels" style="font-size: 13px;">
                <label for="{{ $form_name }}-1">{!! t($labels[0]) !!}</label>
                <label for="{{ $form_name }}-7" style="text-align: right;">{{ $labels[6] }}</label>
                <label for="{{ $form_name }}-0" style="width: 136px; text-align: center;">{!! t("elements.missing") !!}</label>
            </div>
            <div class="radios">
                @for ($i = 0; $i < 7; $i++)
                <div class="radio-7">
                    @if ($i == 0 || $i == 6)
                        <label for="{{ $form_name }}-{{ $i + 1 }}" class="mobile-label">{!! t($labels[$i]) !!}</label>
                    @endif
                    <span class="answer-text">{{ $i + 1 }}</span><br>
                    @if (isset($values[$form_name]) && intval($values[$form_name]) == ($i + 1))
                        <input type="radio" id="{{ $form_name }}-{{ $i + 1 }}" name="{{ $form_name }}" value="{{ $i + 1 }}" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked"> 
                    @else
                        <input type="radio" id="{{ $form_name }}-{{ $i + 1 }}" name="{{ $form_name }}" value="{{ $i + 1 }}" {{ !$editable ? 'disabled="disabled"' : '' }}> 
                    @endif
                </div>
                @endfor
                <div class="radio-7">
                    <label for="{{ $form_name }}-0" class="mobile-label">{!! t("elements.missing") !!}</label>
                    @if (!isset($values[$form_name]) || intval($values[$form_name]) == 0)
                        <input type="radio" id="{{ $form_name }}-0" name="{{ $form_name }}" value="0" {{ !$editable ? 'disabled="disabled"' : '' }} checked="checked">
                    @else
                        <input type="radio" id="{{ $form_name }}-0" name="{{ $form_name }}" value="0" {{ !$editable ? 'disabled="disabled"' : '' }}>
                    @endif
                </div>
            </div>
        @endif
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
