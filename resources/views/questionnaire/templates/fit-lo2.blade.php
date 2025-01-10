@if ($has_subquestion)
<li class="parent-question" id="question-lo2">
@elseif ($is_subquestion)
<li class="subquestion" id="question-lo2">
@elseif (isset($in_special_group) && $in_special_group)
<li class="special-question" id="question-lo2">
@else
<li class="question" id="question-lo2" data-category-id="4">
@endif
    <div class="info">
        <span class="title">{!! t($label) !!}</span>
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
        <input type="text" name="fitO2min" id="fitO2min" value="{{ $values['fitO2min'] ?? '' }}" @disabled(!$editable)>
         l/min
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
