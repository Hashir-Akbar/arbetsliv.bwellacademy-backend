@include('questionnaire.edit-templates._base-c', array('label' => $label, 'name' => $name, 'form_name' => $form_name, 'description' => $description, 'help' => $help))
<div class='section dbg_list-item-c'>
<input type="checkbox" name="items[{{ $name }}][is_conditional]"{{ $is_conditional ? ' checked="checked"' : '' }}>
<label for="is_conditional">{{ t('elements.is_conditional') }}</label><br> 
<label for="toggle_value">{{ t('elements.toggle_value') }}</label>
<select name='items[{{ $name }}][toggle_value]'>
    @for ($i = 1; $i <= 5; $i++)
        <option value='{{ $i }}'{{ $toggle_value == $i ? ' selected="selected"' : '' }}>{{ $i }}</option>
    @endfor
</select><br> 
@if ($is_part_of_conditional)
<input type="checkbox" name="items[{{ $name }}][is_part_of_conditional]" checked="checked">
@else
<input type="checkbox" name="items[{{ $name }}][is_part_of_conditional]">
@endif
<label for="is_part_of_conditional">{{ t('elements.is_part_of_conditional') }}</label><br> 
@for ($i = 0; $i < $count; $i++)
<label>{{ t('elements.radio-'.($i + 1).'-label') }}</label><br>
<input type='text' name='items[{{ $name }}][labels][]' value='{{ $labels[$i] }}'><br>
<label>{{ t('elements.radio-'.($i + 1).'-value') }}</label><br>
<input type='text' name='items[{{ $name }}][items][]' value='{{ $items[$i] }}'><br>
@endfor
</div>