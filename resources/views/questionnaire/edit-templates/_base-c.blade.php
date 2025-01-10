<div class='section dbgbasec'>
@if ($subquestion)
<input type='checkbox' name='items[{{ $name }}][subquestion]' checked='checked'>
@else
<input type='checkbox' name='items[{{ $name }}][subquestion]'>
@endif
<label>{{ t('elements.element-subquestion') }}</label><br>
@if ($has_sub)
<input type='checkbox' name='items[{{ $name }}][has_sub]' checked='checked'>
@else
<input type='checkbox' name='items[{{ $name }}][has_sub]'>
@endif
<label>{{ t('elements.element-has_subquestion') }}</label><br>
<label>{{ t('elements.element-label') }}</label><br>
<input class='question-label' type='text' name='items[{{ $name }}][label]' value='{{ $label }}'><br>
<label>{{ t('elements.element-form_name') }}</label><br>
<input type='text' name='items[{{ $name }}][form_name]' value='{{ $form_name }}'><br>
<input class='form_name' type='hidden' name='items[{{ $name }}][old_form_name]' value='{{ $form_name }}'><br>
<label>{{ t('elements.element-factor') }}</label><br>
<select name='items[{{ $name }}][factor]'>
    <option value="-1">Ingen</option>
    @foreach ($factors as $key => $value)
        @if ($category_id == $key)
        <option value='{{ $key }}' selected='selected'>{{ t($value) }}</option>
        @else
        <option value='{{ $key }}'>{{ t($value) }}</option>
        @endif
    @endforeach
</select><br>
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
<label>{{ t('elements.element-video') }}</label>
<input type='text' name='items[{{ $name }}][video_id]' value='{{ $video_id ?? '' }}'>
</div>