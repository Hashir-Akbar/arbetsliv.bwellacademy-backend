@if ($is_subquestion)
<li class="subquestion">
@elseif ($has_subquestion)
<li class="parent-question">
@else
<li class="question">
@endif
    <div class="info">
        <span class="title">{!! t($label) !!}</span>
        <span class="description">{!! t($description) !!}</span>
    </div>
    <div class="help-button"></div>
    <div class="elements">
        
        <div class="submit-confirmation"></div>
    </div>
    <div class="help">
        <div class="help-icon"></div>
        <p>
            {!! t($help) !!}
        </p>
    </div>
</li>