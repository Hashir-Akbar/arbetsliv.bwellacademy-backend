<input type='hidden' class='weight' name='items[#name][weight]'> \
<div class='section'> \
<label>{{ t('elements.element-label') }}</label><br> \
<input class='question-label' type='text' name='items[#name][label]'><br> \
<label>{{ t('elements.mfr-form_name-left') }}</label><br> \
<input type='text' name='items[#name][form_name][0]'><br> \
<input class='form_name' type='hidden' name='items[#name][old_form_name][0]'><br> \
<label>{{ t('elements.mfr-form_name-right') }}</label><br> \
<input type='text' name='items[#name][form_name][1]'><br> \
<input class='form_name' type='hidden' name='items[#name][old_form_name][1]'><br> \
<input type='hidden' name='items[#name][factor]' value='-1'> \
<label>{{ t('elements.element-description') }}</label><br> \
<textarea name='items[#name][description]'></textarea><br> \
<input type='checkbox' name='items[#name][has_help]'> \
<label>{{ t('elements.element-has_help') }}</label><br> \
<label>{{ t('elements.element-help') }}</label><br> \
<textarea name='items[#name][help]'></textarea><br> \
</div> \
<div class='section'> \
    <label>{{ t('elements.textbox-suffix') }}</label><br> \
    <input type='text' name='items[#name][suffix]'><br> \
</div>