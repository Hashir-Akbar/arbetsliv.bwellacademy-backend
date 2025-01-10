@include('questionnaire.edit-templates._base', array('factors' => $factors)) \
<div class='section'> \
@for ($i = 0; $i < 7; $i++)
<label>{{ trans('elements.radio-'.($i + 1).'-label') }}</label><br> \
<input type='text' name='items[#name][labels][]'><br> \
<label>{{ trans('elements.radio-'.($i + 1).'-value') }}</label><br> \
<input type='text' name='items[#name][items][]'><br> \
@endfor
</div>