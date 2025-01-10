@include('questionnaire.edit-templates._base', array('factors' => $factors)) \
<div class='section dbgradio'> \
@for ($i = 0; $i < 5; $i++)
<label>{{ t('elements.radio-'.($i + 1).'-value') }}</label><br> \
<input type='text' name='items[#name][items][]'><br> \
@endfor
<label>{{ t('elements.radio-min-label') }}</label><br> \
<input type='text' name='items[#name][min]'><br> \
<label>{{ t('elements.radio-max-label') }}</label><br> \
<input type='text' name='items[#name][max]'><br> \
</div>