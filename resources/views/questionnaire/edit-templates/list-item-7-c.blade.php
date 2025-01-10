@include('questionnaire.edit-templates._base-c', array('label' => $label, 'name' => $name, 'form_name' => $form_name, 'description' => $description, 'help' => $help))
<div class='section'>
@if ($is_part_of_conditional)
<input type="checkbox" name="items[{{ $name }}][is_part_of_conditional]" checked="checked">
@else
<input type="checkbox" name="items[{{ $name }}][is_part_of_is_conditional]">
@endif
<label for="is_part_of_conditional">{{ t('elements.is_part_of_conditional') }}</label><br> 
@for ($i = 0; $i < 7; $i++)
<label>{{ trans('elements.radio-'.($i + 1).'-label') }}</label><br>
<input type='text' name='items[{{ $name }}][labels][]' value='{{ $labels[$i] }}'><br>
<label>{{ trans('elements.radio-'.($i + 1).'-value') }}</label><br>
<input type='text' name='items[{{ $name }}][items][]' value='{{ $items[$i] }}'><br>
@endfor
</div>