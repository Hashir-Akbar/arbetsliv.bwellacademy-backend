@include('questionnaire.edit-templates._base-c')
<div class='section'>
    <label>{{ t('elements.estimation-above') }}</label><br>
    <input type='text' name='items[{{ $name }}][labels][]' value='{{ $labels[0] }}'><br>
    <label>{{ t('elements.estimation-below') }}</label><br>
    <input type='text' name='items[{{ $name }}][labels][]' value='{{ $labels[1] }}'><br>
    <label>{{ t('elements.estimation-correct') }}</label><br>
    <input type='text' name='items[{{ $name }}][labels][]' value='{{ $labels[2] }}'><br>
</div>