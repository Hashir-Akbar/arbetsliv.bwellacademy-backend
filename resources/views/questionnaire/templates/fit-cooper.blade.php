@if ($has_subquestion)
<li class="parent-question" id="question-cooper">
@elseif ($is_subquestion)
<li class="subquestion" id="question-cooper">
@elseif (isset($in_special_group) && $in_special_group)
<li class="special-question" id="question-cooper">
@else
<li class="question" id="question-cooper" data-category-id="4">
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
        <input type="text" id="fitCooperDistance" name="fitCooperDistance" value="{{ $values['fitCooperDistance'] ?? '' }}" @disabled(!$editable)>
         m
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
