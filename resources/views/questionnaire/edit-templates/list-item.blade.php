@include('questionnaire.edit-templates._base', array('factors' => $factors)) \
<div class='section dbg_list-item'> \
<label for='is_part_of_conditional'>{{ t('elements.is_part_of_conditional') }}</label> \
<input type='checkbox' name='items[#name][is_part_of_conditional]'><br> \
@for ($i = 0; $i < $count; $i++)
<label>{{ t('elements.radio-'.($i + 1).'-label') }}</label><br> \
<input type='text' name='items[#name][labels][]'><br> \
<label>{{ t('elements.radio-'.($i + 1).'-value') }}</label><br> \
<input type='text' name='items[#name][items][]'><br> \
@endfor
</div>