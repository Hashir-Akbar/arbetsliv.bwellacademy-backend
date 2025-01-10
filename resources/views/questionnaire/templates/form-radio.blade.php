@if ($has_subquestion)
<li class="parent-question">
@elseif ($is_subquestion)
<li class="subquestion">
@elseif (isset($in_special_group) && $in_special_group)
<li class="special-question">
@else
<li class="question">
@endif
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
        <div class="radio-5">
            <label for="{{ $form_name }}-1">{!! t($min) !!}</label><br>
            @if (isset($values[$form_name]) && intval($values[$form_name]) == intval($items[0]))
                <input type="radio" id="{{ $form_name }}-1" name="{{ $form_name }}" value="{{ $items[0] }}" checked="checked">
            @else
                <input type="radio" id="{{ $form_name }}-1" name="{{ $form_name }}" value="{{ $items[0] }}">
            @endif
        </div>
        <div class="radio-5">
            <label for="{{ $form_name }}-2">&nbsp;</label><br>
            @if (isset($values[$form_name]) && intval($values[$form_name]) == intval($items[1]))
                <input type="radio" id="{{ $form_name }}-2" name="{{ $form_name }}" value="{{ $items[1] }}" checked="checked">
            @else
                <input type="radio" id="{{ $form_name }}-2" name="{{ $form_name }}" value="{{ $items[1] }}">
            @endif
        </div>
        <div class="radio-5">
            <label for="{{ $form_name }}-3">&nbsp;</label><br>
            @if (isset($values[$form_name]) && intval($values[$form_name]) == intval($items[2]))
                <input type="radio" id="{{ $form_name }}-3" name="{{ $form_name }}" value="{{ $items[2] }}" checked="checked">
            @else
                <input type="radio" id="{{ $form_name }}-3" name="{{ $form_name }}" value="{{ $items[2] }}">
            @endif
        </div>
        <div class="radio-5">
            <label for="{{ $form_name }}-4">&nbsp;</label><br>
            @if (isset($values[$form_name]) && intval($values[$form_name]) == intval($items[3]))
                <input type="radio" id="{{ $form_name }}-4" name="{{ $form_name }}" value="{{ $items[3] }}" checked="checked">
            @else
                <input type="radio" id="{{ $form_name }}-4" name="{{ $form_name }}" value="{{ $items[3] }}">
            @endif
        </div>
        <div class="radio-5">
            <label for="{{ $form_name }}-5">{!! t($max) !!}</label><br>
            @if (isset($values[$form_name]) && intval($values[$form_name]) == intval($items[4]))
                <input type="radio" id="{{ $form_name }}-5" name="{{ $form_name }}" value="{{ $items[4] }}" checked="checked">
            @else
                <input type="radio" id="{{ $form_name }}-5" name="{{ $form_name }}" value="{{ $items[4] }}">
            @endif
        </div>
        <div class="radio-5">
            <label for="{{ $form_name }}-0">{!! t("elements.missing") !!}</label><br>
            @if (isset($values[$form_name]) && intval($values[$form_name]) == -1)
                <input type="radio" id="{{ $form_name }}-0" name="{{ $form_name }}" value="-1" checked="checked">
            @else
                <input type="radio" id="{{ $form_name }}-0" name="{{ $form_name }}" value="-1">
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