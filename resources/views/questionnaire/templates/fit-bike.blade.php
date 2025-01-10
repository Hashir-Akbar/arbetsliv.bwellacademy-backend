@if ($has_subquestion)
<li class="parent-question" id="question-bicycle">
@elseif ($is_subquestion)
<li class="subquestion" id="question-bicycle">
@elseif (isset($in_special_group) && $in_special_group)
<li class="special-question" id="question-bicycle">
@else
<li class="question" id="question-bicycle" data-category-id="4">
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
        <table class="bike-table fitness-table">
            <thead>
                <tr>
                    <th></th>
                    <th>Puls</th>
                    <th>(Borg)</th>
                    <th>Watt</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label">Min 1</td>
                    <td class="text">
                        <input type="text" name="fitBicPulse1" id="fitBicPulse1" value="{{ $values['fitBicPulse1'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBicBorg1', 'value' => isset($values['fitBicBorg1']) ? $values['fitBicBorg1'] : ''))</td>
                    <td class="select">
                        @include('physical.watt', array('name' => 'fitBicWatts1', 'value' => isset($values['fitBicWatts1']) ? $values['fitBicWatts1'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 2</td>
                    <td class="text">
                        <input type="text" name="fitBicPulse2" id="fitBicPulse2" value="{{ $values['fitBicPulse2'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBicBorg2', 'value' => isset($values['fitBicBorg2']) ? $values['fitBicBorg2'] : ''))</td>
                    <td class="select">
                        @include('physical.watt', array('name' => 'fitBicWatts2', 'value' => isset($values['fitBicWatts2']) ? $values['fitBicWatts2'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 3</td>
                    <td class="text">
                        <input type="text" name="fitBicPulse3" id="fitBicPulse3" value="{{ $values['fitBicPulse3'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBicBorg3', 'value' => isset($values['fitBicBorg3']) ? $values['fitBicBorg3'] : ''))</td>
                    <td class="select">
                        @include('physical.watt', array('name' => 'fitBicWatts3', 'value' => isset($values['fitBicWatts3']) ? $values['fitBicWatts3'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 4</td>
                    <td class="text">
                        <input type="text" name="fitBicPulse4" id="fitBicPulse4" value="{{ $values['fitBicPulse4'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBicBorg4', 'value' => isset($values['fitBicBorg4']) ? $values['fitBicBorg4'] : ''))</td>
                    <td class="select">
                        @include('physical.watt', array('name' => 'fitBicWatts4', 'value' => isset($values['fitBicWatts4']) ? $values['fitBicWatts4'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 5</td>
                    <td class="text">
                        <input type="text" name="fitBicPulse5" id="fitBicPulse5" value="{{ $values['fitBicPulse5'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBicBorg5', 'value' => isset($values['fitBicBorg5']) ? $values['fitBicBorg5'] : ''))</td>
                    <td class="select">
                        @include('physical.watt', array('name' => 'fitBicWatts5', 'value' => isset($values['fitBicWatts5']) ? $values['fitBicWatts5'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 6</td>
                    <td class="text">
                        <input type="text" name="fitBicPulse6" id="fitBicPulse6" value="{{ $values['fitBicPulse6'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBicBorg6', 'value' => isset($values['fitBicBorg6']) ? $values['fitBicBorg6'] : ''))</td>
                    <td class="select">
                        @include('physical.watt', array('name' => 'fitBicWatts6', 'value' => isset($values['fitBicWatts6']) ? $values['fitBicWatts6'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 7</td>
                    <td class="text">
                        <input type="text" name="fitBicPulse7" id="fitBicPulse7" value="{{ $values['fitBicPulse7'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBicBorg7', 'value' => isset($values['fitBicBorg7']) ? $values['fitBicBorg7'] : ''))</td>
                    <td class="select">
                        @include('physical.watt', array('name' => 'fitBicWatts7', 'value' => isset($values['fitBicWatts7']) ? $values['fitBicWatts7'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 8</td>
                    <td class="text">
                        <input type="text" name="fitBicPulse8" id="fitBicPulse8" value="{{ $values['fitBicPulse8'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBicBorg8', 'value' => isset($values['fitBicBorg8']) ? $values['fitBicBorg8'] : ''))</td>
                    <td class="select">
                        @include('physical.watt', array('name' => 'fitBicWatts8', 'value' => isset($values['fitBicWatts8']) ? $values['fitBicWatts8'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 9</td>
                    <td class="text">
                        <input type="text" name="fitBicPulse9" id="fitBicPulse9" value="{{ $values['fitBicPulse9'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBicBorg9', 'value' => isset($values['fitBicBorg9']) ? $values['fitBicBorg9'] : ''))</td>
                    <td class="select">
                        @include('physical.watt', array('name' => 'fitBicWatts9', 'value' => isset($values['fitBicWatts9']) ? $values['fitBicWatts9'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 10</td>
                    <td class="text">
                        <input type="text" name="fitBicPulse10" id="fitBicPulse10" value="{{ $values['fitBicPulse10'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBicBorg10', 'value' => isset($values['fitBicBorg10']) ? $values['fitBicBorg10'] : ''))</td>
                    <td class="select">
                        @include('physical.watt', array('name' => 'fitBicWatts10', 'value' => isset($values['fitBicWatts10']) ? $values['fitBicWatts10'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 11</td>
                    <td class="text">
                        <input type="text" name="fitBicPulse11" id="fitBicPulse11" value="{{ $values['fitBicPulse11'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBicBorg11', 'value' => isset($values['fitBicBorg11']) ? $values['fitBicBorg11'] : ''))</td>
                    <td class="select">
                        @include('physical.watt', array('name' => 'fitBicWatts11', 'value' => isset($values['fitBicWatts11']) ? $values['fitBicWatts11'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 12</td>
                    <td class="text">
                        <input type="text" name="fitBicPulse12" id="fitBicPulse12" value="{{ $values['fitBicPulse12'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBicBorg12', 'value' => isset($values['fitBicBorg12']) ? $values['fitBicBorg12'] : ''))</td>
                    <td class="select">
                        @include('physical.watt', array('name' => 'fitBicWatts12', 'value' => isset($values['fitBicWatts12']) ? $values['fitBicWatts12'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Steady state</td>
                    <td class="text">
                        <input type="text" name="fitBicPulseSteady" id="fitBicPulseSteady" value="{{ $values['fitBicPulseSteady'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBicBorgSteady', 'value' => isset($values['fitBicBorgSteady']) ? $values['fitBicBorgSteady'] : ''))</td>
                    <td class="select">
                        @include('physical.watt', array('name' => 'fitBicWattsSteady', 'value' => isset($values['fitBicWattsSteady']) ? $values['fitBicWattsSteady'] : ''))
                    </td>
                </tr>
            </tbody>
        </table>
        @include("questionnaire.templates._fit-table", array('fitnessTableClass' => "bike"))
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
