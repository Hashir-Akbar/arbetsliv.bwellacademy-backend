<li class="question">
    <div class="info">
        <span class="title">{!! t($label) !!}</span>
        <span class="description">{!! t($description) !!}</span>
    </div>
    @if ($has_help)
        <?php $thelp = t($help); ?>
        @if (!empty($thelp))
        <div class="help-button"></div>
        @else
        <div class="help-button-disabled"></div>
        @endif
    @else
    <div class="help-button-padding"></div>
    @endif
    <div class="elements">
        Uträknat BMI: <span id="bmi-results">0</span>
    </div>
    @if ($has_help)
    <div class="help">
        <div class="help-icon"></div>
        <p>
            {!! t($help) !!}
        </p>
    </div>
    @endif
</li>
<script>
    $(document).ready(function()
    {
        calculateBMI();

        $('li').delegate('input[type="text"]', 'keyup', function()
        {
            calculateBMI();
        });
    });

    function calculateBMI()
    {
        var weight = parseInt($("input[name='weight']").val());
        var length = parseInt($("input[name='length']").val()) / 100;

        if (isNaN(weight) || isNaN(length))
        {
            $("#bmi-results").html(0);
            return;
        }

        var bmi = weight / (length * length);
        $("#bmi-results").html(bmi.toFixed(2));

        // sendInput?
    }
</script>