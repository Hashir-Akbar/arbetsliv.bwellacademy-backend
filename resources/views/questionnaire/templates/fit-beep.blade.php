@if ($has_subquestion)
<li class="parent-question" id="question-beep">
@elseif ($is_subquestion)
<li class="subquestion" id="question-beep">
@elseif (isset($in_special_group) && $in_special_group)
<li class="special-question" id="question-beep">
@else
<li class="question" id="question-beep" data-category-id="4">
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

        <table class="beep-test">
            <tr class="level">
                <td>Level</td>
                <td>
                    <input type="text" id="fitBeepLevel" name="fitBeepLevel" value="{{ $values['fitBeepLevel'] ?? '' }}" @disabled(!$editable)>
                </td>
            </tr>
            <tr class="shuttles">
                <td>Number of shuttles</td>
                <td>
                    <input type="text" id="fitBeepShuttles" name="fitBeepShuttles" value="{{ $values['fitBeepShuttles'] ?? '' }}" @disabled(!$editable)>
                 </td>
            </tr>
        </table>

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
