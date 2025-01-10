<div class='section'>
<label>{{ t('elements.element-label') }}</label><br>
<input class='question-label' type='text' name='items[{{ $name }}][label]' value='{{ $label }}'><br>
<input type='hidden' name='items[{{ $name }}][form_name]' value='fitMethod'>
<input type='hidden' name='items[{{ $name }}][old_form_name]' value='fitMethod'>
<label>{{ t('elements.element-description') }}</label><br>
<textarea name='items[{{ $name }}][description]'>{{ $description }}</textarea><br>
@if ($has_help)
<input type='checkbox' name='items[{{ $name }}][has_help]' checked='checked'> 
@else
<input type='checkbox' name='items[{{ $name }}][has_help]'> 
@endif
<label>{{ t('elements.element-has_help') }}</label><br>
<label>{{ t('elements.element-help') }}</label><br>
<textarea name='items[{{ $name }}][help]'>{{ $help }}</textarea><br>
</div>