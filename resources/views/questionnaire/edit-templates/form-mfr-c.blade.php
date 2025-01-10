<div class='section dbgmfrc'>
<label>{{ t('elements.element-form_name') }}</label><br>
<input type='text' name='items[{{ $name }}][form_name]' value='{{ $form_name }}'><br>
<input type='hidden' name='items[{{ $name }}][old_form_name]' value='{{ $form_name }}'>
<input type='hidden' name='items[{{ $name }}][factor]' value='-1'>
<label>{{ t('elements.element-help') }}</label><br>
<textarea name='items[{{ $name }}][help]'>{{ $help }}</textarea><br>
</div>