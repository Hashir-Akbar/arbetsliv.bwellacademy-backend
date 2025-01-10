<input type='hidden' class='weight' name='items[#name][weight]'> \
<div class='section'> \
<label>{{ t('elements.element-label') }}</label><br> \
<input class='question-label' type='text' name='items[#name][label]'><br> \
<label>{{ t('elements.element-form_name') }}</label><br> \
<input type='text' name='items[#name][form_name]'><br> \
<input type='hidden' name='items[#name][old_form_name]'><br> \
<label>{{ t('elements.element-description') }}</label><br> \
<textarea name='items[#name][description]'></textarea><br> \
<input type='checkbox' name='items[#name][has_help]'> \
<label>{{ t('elements.element-has_help') }}</label><br> \
<label>{{ t('elements.element-help') }}</label><br> \
<textarea name='items[#name][help]'></textarea><br> \
<input type='hidden' name='items[#name][factor]' value='0'> \
</div>