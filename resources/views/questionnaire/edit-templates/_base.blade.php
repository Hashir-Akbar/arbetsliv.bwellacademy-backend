<input type='hidden' class='weight' name='items[#name][weight]'> \
<div class='section dbgbase'> \
<input type='checkbox' name='items[#name][subquestion]'> \
<label>{{ t('elements.element-subquestion' )}}</label><br> \
<input type='checkbox' name='items[#name][has_sub]'> \
<label>{{ t('elements.element-has_subquestion' )}}</label><br> \
<label>{{ t('elements.element-label') }}</label><br> \
<input class='question-label' type='text' name='items[#name][label]'><br> \
<label>{{ t('elements.element-form_name') }}</label><br> \
<input type='text' name='items[#name][form_name]'><br> \
<input type='hidden' name='items[#name][old_form_name]'><br> \
<label>{{ t('elements.element-factor') }}</label><br> \
<select name='items[#name][factor]'> \
    <option value='-1'>Ingen</option> \
    @foreach ($factors as $key => $value)
    <option value='{{ $key }}'>{{ t($value) }}</option> \
    @endforeach
</select><br> \
<label>{{ t('elements.element-description') }}</label><br> \
<textarea name='items[#name][description]'></textarea><br> \
<input type='checkbox' name='items[#name][has_help]'> \
<label>{{ t('elements.element-has_help') }}</label><br> \
<label>{{ t('elements.element-help') }}</label><br> \
<textarea name='items[#name][help]'></textarea><br> \
<label>{{ t('elements.element-video') }}</label> \
<input type='text' name='items[#name][video_id]'> \
</div>