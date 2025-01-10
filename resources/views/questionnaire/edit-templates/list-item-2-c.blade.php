@include('questionnaire.edit-templates._base-c', array('label' => $label, 'name' => $name, 'form_name' => $form_name, 'description' => $description, 'help' => $help))
<div class='section dbg2c'>
@if ($is_conditional)
<input type="checkbox" name="items[{{ $name }}][is_conditional]" checked="checked">
@else
<input type="checkbox" name="items[{{ $name }}][is_conditional]">
@endif
<label for="is_conditional">{{ t('elements.is_conditional') }}</label><br>
@if ($is_part_of_conditional)
<input type="checkbox" name="items[{{ $name }}][is_part_of_conditional]" checked="checked">
@else
<input type="checkbox" name="items[{{ $name }}][is_part_of_conditional]">
@endif
<label for="is_part_of_conditional">{{ t('elements.is_part_of_conditional') }}</label><br> 
<label>{{ t('elements.radio-yes-label') }}</label><br>
<input type='text' name='items[{{ $name }}][labels][1]' value='{{ $labels[1] }}'><br>
<label>{{ t('elements.radio-yes-value') }}</label><br>
<input type='text' name='items[{{ $name }}][items][1]' value='{{ $items[1] }}'><br>
<label>{{ t('elements.radio-no-label') }}</label><br>
<input type='text' name='items[{{ $name }}][labels][0]' value='{{ $labels[0] }}'><br>
<label>{{ t('elements.radio-no-value') }}</label><br>
<input type='text' name='items[{{ $name }}][items][0]' value='{{ $items[0] }}'><br>
</div>