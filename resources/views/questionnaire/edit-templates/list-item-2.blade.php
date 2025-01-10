@include('questionnaire.edit-templates._base', array('factors' => $factors)) \
<div class='section dbg2'> \
<label for='is_conditional'>{{ t('elements.is_conditional') }}</label> \
<input type='checkbox' name='items[#name][is_conditional]'><br> \
<label for='is_part_of_conditional'>{{ t('elements.is_part_of_conditional') }}</label> \
<input type='checkbox' name='items[#name][is_part_of_conditional]'><br> \
<label>{{ t('elements.radio-yes-label') }}</label><br> \
<input type='text' name='items[#name][labels][1]'><br> \
<label>{{ t('elements.radio-yes-value') }}</label><br> \
<input type='text' name='items[#name][items][1]'><br> \
<label>{{ t('elements.radio-no-label') }}</label><br> \
<input type='text' name='items[#name][labels][0]'><br> \
<label>{{ t('elements.radio-no-value') }}</label><br> \
<input type='text' name='items[#name][items][0]'><br> \
</div>