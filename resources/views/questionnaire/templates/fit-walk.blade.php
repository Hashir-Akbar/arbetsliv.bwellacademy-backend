@if ($has_subquestion)
<li class="parent-question" id="question-walk">
@elseif ($is_subquestion)
<li class="subquestion" id="question-walk">
@elseif (isset($in_special_group) && $in_special_group)
<li class="special-question" id="question-walk">
@else
<li class="question" id="question-walk" data-category-id="4">
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
        <table class="walk-test">
            <tr class="pulse">
                <td>Puls</td>
                <td>
                    <input type="text" id="fitWalkPulse" name="fitWalkPulse" value="{{ $values['fitWalkPulse'] ?? '' }}" @disabled(!$editable)>
                </td>
            </tr>
            <tr class="distance">
                <td>Sträcka</td>
                <td>
                    <input type="text" id="fitWalkDistance" name="fitWalkDistance" value="{{ $values['fitWalkDistance'] ?? '' }}" @disabled(!$editable)>
                     meter
                 </td>
            </tr>
            <tr class="minutes">
                <td>Minuter</td>
                <td>
                    <input type="text" id="fitWalkMin" name="fitWalkMin" value="{{ $values['fitWalkMin'] ?? '' }}" @disabled(!$editable)>
                </td>
            </tr>
            <tr class="seconds">
                <td>Sekunder</td>
                <td>
                    <input type="text" id="fitWalkSec" name="fitWalkSec" value="{{ $values['fitWalkSec'] ?? '' }}" @disabled(!$editable)>
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
