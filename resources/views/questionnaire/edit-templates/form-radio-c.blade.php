@include('questionnaire.edit-templates._base-c', array('label' => $label, 'name' => $name, 'form_name' => $form_name, 'description' => $description,'help' => $help))
<div class='section dbgradioc'>
@for ($i = 0; $i < 5; $i++)
<label>{{ t('elements.radio-'.($i + 1).'-value') }}</label><br>
<input type='text' name='items[{{ $name }}][items][]' value='{{ $items[$i] }}'><br>
@endfor
<label>{{ t('elements.radio-min-label') }}</label><br>
<input type='text' name='items[{{ $name }}][min]' value='{{ $min }}'><br>
<label>{{ t('elements.radio-max-label') }}</label><br>
<input type='text' name='items[{{ $name }}][max]' value='{{ $max }}'><br>
</div>