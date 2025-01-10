@if ($has_subquestion)
<li class="parent-question" id="question-step">
@elseif ($is_subquestion)
<li class="subquestion" id="question-step">
@elseif (isset($in_special_group) && $in_special_group)
<li class="special-question" id="question-step">
@else
<li class="question" id="question-step" data-category-id="4">
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
        <table class="step-table fitness-table">
            <thead>
                <tr>
                    <th class="label"></th>
                    <th class="text">Puls</th>
                    <th class="select">(Borg)</th>
                    <th class="select">Bänkhöjd</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label">Min 1</td>
                    <td class="text">
                        <input type="text" name="fitPulse1" id="fitPulse1" value="{{ $values['fitPulse1'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBorg1', 'value' => isset($values['fitBorg1']) ? $values['fitBorg1'] : ''))</td>
                    <td class="select">
                        @include('physical.bench', array('name' => 'fitBench1', 'value' => isset($values['fitBench1']) ? $values['fitBench1'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 2</td>
                    <td class="text">
                        <input type="text" name="fitPulse2" id="fitPulse2" value="{{ $values['fitPulse2'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBorg2', 'value' => isset($values['fitBorg2']) ? $values['fitBorg2'] : ''))</td>
                    <td class="select">
                        @include('physical.bench', array('name' => 'fitBench2', 'value' => isset($values['fitBench2']) ? $values['fitBench2'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 3</td>
                    <td class="text">
                        <input type="text" name="fitPulse3" id="fitPulse3" value="{{ $values['fitPulse3'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBorg3', 'value' => isset($values['fitBorg3']) ? $values['fitBorg3'] : ''))</td>
                    <td class="select">
                        @include('physical.bench', array('name' => 'fitBench3', 'value' => isset($values['fitBench3']) ? $values['fitBench3'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 4</td>
                    <td class="text">
                        <input type="text" name="fitPulse4" id="fitPulse4" value="{{ $values['fitPulse4'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBorg4', 'value' => isset($values['fitBorg4']) ? $values['fitBorg4'] : ''))</td>
                    <td class="select">
                        @include('physical.bench', array('name' => 'fitBench4', 'value' => isset($values['fitBench4']) ? $values['fitBench4'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 5</td>
                    <td class="text">
                        <input type="text" name="fitPulse5" id="fitPulse5" value="{{ $values['fitPulse5'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBorg5', 'value' => isset($values['fitBorg5']) ? $values['fitBorg5'] : ''))</td>
                    <td class="select">
                        @include('physical.bench', array('name' => 'fitBench5', 'value' => isset($values['fitBench5']) ? $values['fitBench5'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 6</td>
                    <td class="text">
                        <input type="text" name="fitPulse6" id="fitPulse6" value="{{ $values['fitPulse6'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBorg6', 'value' => isset($values['fitBorg6']) ? $values['fitBorg6'] : ''))</td>
                    <td class="select">
                        @include('physical.bench', array('name' => 'fitBench6', 'value' => isset($values['fitBench6']) ? $values['fitBench6'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 7</td>
                    <td class="text">
                        <input type="text" name="fitPulse7" id="fitPulse7" value="{{ $values['fitPulse7'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBorg7', 'value' => isset($values['fitBorg7']) ? $values['fitBorg7'] : ''))</td>
                    <td class="select">
                        @include('physical.bench', array('name' => 'fitBench7', 'value' => isset($values['fitBench7']) ? $values['fitBench7'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 8</td>
                    <td class="text">
                        <input type="text" name="fitPulse8" id="fitPulse8" value="{{ $values['fitPulse8'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBorg8', 'value' => isset($values['fitBorg8']) ? $values['fitBorg8'] : ''))</td>
                    <td class="select">
                        @include('physical.bench', array('name' => 'fitBench8', 'value' => isset($values['fitBench8']) ? $values['fitBench8'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 9</td>
                    <td class="text">
                        <input type="text" name="fitPulse9" id="fitPulse9" value="{{ $values['fitPulse9'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBorg9', 'value' => isset($values['fitBorg9']) ? $values['fitBorg9'] : ''))</td>
                    <td class="select">
                        @include('physical.bench', array('name' => 'fitBench9', 'value' => isset($values['fitBench9']) ? $values['fitBench9'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 10</td>
                    <td class="text">
                        <input type="text" name="fitPulse10" id="fitPulse10" value="{{ $values['fitPulse10'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBorg10', 'value' => isset($values['fitBorg10']) ? $values['fitBorg10'] : ''))</td>
                    <td class="select">
                        @include('physical.bench', array('name' => 'fitBench10', 'value' => isset($values['fitBench10']) ? $values['fitBench10'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 11</td>
                    <td class="text">
                        <input type="text" name="fitPulse11" id="fitPulse11" value="{{ $values['fitPulse11'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBorg11', 'value' => isset($values['fitBorg11']) ? $values['fitBorg11'] : ''))</td>
                    <td class="select">
                        @include('physical.bench', array('name' => 'fitBench11', 'value' => isset($values['fitBench11']) ? $values['fitBench11'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Min 12</td>
                    <td class="text">
                        <input type="text" name="fitPulse12" id="fitPulse12" value="{{ $values['fitPulse12'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBorg12', 'value' => isset($values['fitBorg12']) ? $values['fitBorg12'] : ''))</td>
                    <td class="select">
                        @include('physical.bench', array('name' => 'fitBench12', 'value' => isset($values['fitBench12']) ? $values['fitBench12'] : ''))
                    </td>
                </tr>
                <tr>
                    <td class="label">Steady state</td>
                    <td class="text">
                        <input type="text" name="fitPulseSteady" id="fitPulseSteady" value="{{ $values['fitPulseSteady'] ?? '' }}" @disabled(!$editable)>
                    </td>
                    <td class="select">@include('physical.borg', array('name' => 'fitBorgSteady', 'value' => isset($values['fitBorgSteady']) ? $values['fitBorgSteady'] : ''))</td>
                    <td class="select">
                        @include('physical.bench', array('name' => 'fitBenchSteady', 'value' => isset($values['fitBenchSteady']) ? $values['fitBenchSteady'] : ''))
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" id="fitMaxEst" name="fitMaxEst" value="{{ $values['fitMaxEst'] ?? '' }}">
        @include("questionnaire.templates._fit-table", array('fitnessTableClass' => "step"))
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
