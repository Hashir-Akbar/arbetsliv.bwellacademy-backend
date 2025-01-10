@include('questionnaire.edit-templates._base', array('factors' => $factors)) \
<div class='section'> \
    <label>{{ t('elements.textbox-suffix') }}</label><br> \
    <input type='text' name='items[#name][suffix]'><br> \
</div>