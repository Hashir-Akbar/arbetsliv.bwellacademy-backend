@include('questionnaire.edit-templates._base') \
<div class='section'> \
    <label>{{ t('elements.estimation-above') }}</label><br> \
    <input type='text' name='items[#name][labels][]'><br> \
    <label>{{ t('elements.estimation-below') }}</label><br> \
    <input type='text' name='items[#name][labels][]'><br> \
    <label>{{ t('elements.estimation-correct') }}</label><br> \
    <input type='text' name='items[#name][labels][]'><br> \
</div>