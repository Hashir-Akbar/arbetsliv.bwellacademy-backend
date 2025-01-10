@include('questionnaire.edit-templates._base-c', array('label' => $label, 'name' => $name, 'form_name' => $form_name, 'description' => $description, 'help' => $help))
<div class='section'>
    <label>{{ t('elements.textbox-suffix') }}</label><br>
    <input type='text' name='items[{{ $name }}][suffix]' value='{{ $suffix }}'><br>
</div>