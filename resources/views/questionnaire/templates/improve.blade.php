<?php
if (empty($category_id)) {
    return;
}
if (!isset($factors[$category_id])) {
    return;
}
$factor = $factors[$category_id];

$improve = $factor->improve;

$show_improve = $factor->status != 'profile.unknown';
if ($show_improve) {
    $statusClass = 'status-' . ($factor->status == 'profile.risk' ? 'risk' : 'healthy');
    if (App::isLocale('sv')) {
        $status = 'Du har värde <span class="' . $statusClass . '">' . $factor->value . '</span> - ' . t($factor->status);
    } else {
        $status = 'Your value is  <span class="' . $statusClass . '">' . $factor->value . '</span> - ' . t($factor->status);
    }
} else {
    if (App::isLocale('sv')) {
        $status = 'Du har inget värde än';
    } else {
        $status = 'You don\'t have a value yet';
    }
}

if (isset($dont_hide)) {
    $show_improve = true;
}

$fitness_category = App\QuestionnaireCategory::where('name', 'fitness')->first();
if ($category_id == $fitness_category->id) {
    $weight = $values['weight'] ?? '';
    if (empty($weight)) {
        if (App::isLocale('sv')) {
            $fitness_text = 'Du måste ange din vikt först';
        } else {
            $fitness_text = 'You must enter your weight first';
        }
        $status = '';
    } else {
        if ($show_improve) {
            $fitO2min = $values['fitO2min'] ?? '';
            $fitO2kg = $values['fitO2kg'] ?? '';
            $fitness_text = $fitO2min . ' L/min, ' . $fitO2kg . ' ml/kg/min';
        } else {
            $fitness_text = '';
        }
    }
}
?>
<div class="improve category{{ $category_id }}" {{ $show_improve ? '' : 'hidden' }}>
    @if ($category_id == $fitness_category->id)
        <div class="fitness-text">{!! $fitness_text !!}</div>
    @endif
    <div class="improve-status">
        <div class="status">{!! $status !!}</div>
    </div>
    <div class="improve-question">
        <div class="improve-values">
            <div class="improve-value">
                <input type="radio" id="{{ $name }}-improve-1" class="improve" name="{{ $name }}-improve" value="1" data-category-id="{{ $category_id }}" data-type="improve-question" @checked($improve == 1) @disabled(!$editable)>
                <label for="{{ $name }}-improve-1">{!! t("elements.improve-1") !!}</label>
            </div>
            <div class="improve-value">
                <input type="radio" id="{{ $name }}-improve-2" class="improve" name="{{ $name }}-improve" value="2" data-category-id="{{ $category_id }}" data-type="improve-question" @checked($improve == 2) @disabled(!$editable)>
                <label for="{{ $name }}-improve-2">{!! t("elements.improve-2") !!}</label>
            </div>
        </div>
    </div>
</div>