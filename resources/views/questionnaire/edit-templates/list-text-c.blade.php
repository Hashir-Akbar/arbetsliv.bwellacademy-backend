@include('questionnaire.edit-templates._base-c', array('label' => $label, 'name' => $name, 'form_name' => $form_name, 'description' => $description, 'help' => $help))
<div class="section">
@if ($is_part_of_conditional)
<input type="checkbox" name="items[{{ $name }}][is_part_of_conditional]" checked="checked">
@else
<input type="checkbox" name="items[{{ $name }}][is_part_of_conditional]">
@endif
<label for="is_part_of_conditional">{{ t('elements.is_part_of_conditional') }}</label><br> 
</div>