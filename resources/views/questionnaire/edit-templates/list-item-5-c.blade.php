@include('questionnaire.edit-templates._base-c', array('label' => $label, 'name' => $name, 'form_name' => $form_name, 'description' => $description, 'help' => $help))
<div class='section dbg5c'>
@for ($i = 0; $i < 5; $i++)
<label>{{ trans('elements.radio-'.($i + 1).'-label') }}</label><br>
<input type='text' name='items[{{ $name }}][labels][]' value='{{ $labels[$i] }}'><br>
<label>{{ trans('elements.radio-'.($i + 1).'-value') }}</label><br>
<input type='text' name='items[{{ $name }}][items][]' value='{{ $items[$i] }}'><br>
@endfor
</div>