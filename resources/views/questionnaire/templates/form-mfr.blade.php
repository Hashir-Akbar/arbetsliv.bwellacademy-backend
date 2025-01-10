@if (isset($in_special_group) && $in_special_group)
<li class="special-question mfr">
@else
<li class="mfr">
@endif
    <div class="info">
        <table class="mfr-table" style="color: #777">
            <thead>
                <tr>
                    <th style="border-bottom: 1px solid #777; min-width: 80px">M</th>
                    <th style="border-bottom: 1px solid #777; min-width: 80px">K</th>
                    <th class="results" style="border-bottom: 1px solid #777; min-width: 80px"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="2">fett/muskler</th>
                    <th></th>
                </tr>
                <tr>
                    <th colspan="2">max</th>
                    <td class="results">
                        <span id="wghtMusclMax"></span> kg
                    </td>
                </tr>
                <tr>
                    <td>4 x S</td>
                    <td>4,75 x S</td>
                    <td></td>
                </tr>
                <tr>
                    <th colspan="2" style="border-top: 1px dotted #666">min</th>
                    <td class="results" style="border-top: 1px dotted #666">
                        <span id="wghtMusclMin"></span> kg
                    </td>
                </tr>
                <tr>
                    <td>3 x S</td>
                    <td>3,5 x S</td>
                    <td></td>
                </tr>
                <tr>
                    <th colspan="2" style="border-top: 1px solid #777">blod/organ/hud</th>
                    <td class="results" style="border-top: 1px solid #777">
                        <span id="wghtOrgans"></span> kg
                    </td>
                </tr>
                <tr>
                    <td colspan="2">1,5 x S</td>
                    <td></td>
                </tr>
                <tr>
                    <th colspan="2" style="border-top: 1px solid #777">skelett</th>
                    <td class="results" style="border-top: 1px solid #777">
                        <span id="wghtSkel"></span> kg
                    </td>
                </tr>
                <tr>
                    <td colspan="2">S</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="help-button"></div>
    <div class="elements" style="color: #777">
        <strong>rekommenderad vikt</strong><br>
        <strong>max</strong> <span id="wghtMax">0</span> kg<br>
        <strong>min</strong> <span id="wghtMin">0</span> kg<br>
    </div>
    <div class="help">
        <div class="help-icon"></div>
        <p>
            För att få veta mer exakt vad du bör väga kan du göra en mätning av din benstomme. Fråga din skolsköterska eller idrottslärare om de kan göra en sådan mätning.<br>Annars går du vidare till fråga 14: Värderad vikt
        </p>
    </div>
</li>
<script>
    $(document).ready(function()
    {
        calculateMFR();

        $('li').delegate('input[type="text"]', 'keyup', function()
        {
            calculateMFR();
        });
    });

    function resetMFR()
    {
        $("#wghtSkel").html("");
        $("#wghtOrgans").html("");
        $("#wghtMusclMin").html("");
        $("#wghtMusclMax").html("");
        $("#wghtMin").html("");
        $("#wghtMax").html("");
    }

    function calculateMFR()
    {
        //var weight = parseInt($("input[name='weight']").val());
        var length = parseFloat($("input[name='length']").val().replace(',','.'));

        var wristL = parseFloat($("input[name='bodyWristL']").val().replace(',','.'));
        var wristR = parseFloat($("input[name='bodyWristR']").val().replace(',','.'));
        var wristSum = wristL + wristR;

        var kneeL = parseFloat($("input[name='bodyKneeL']").val().replace(',','.'));
        var kneeR = parseFloat($("input[name='bodyKneeR']").val().replace(',','.'));
        var kneeSum = kneeL + kneeR;

        var sqLength = length * length;
        var step2 = (sqLength * wristSum * kneeSum) / 1000000;
        var powStep2 = Math.pow(step2, 0.712);
        var skel = (3.02 * powStep2);

        if (isNaN(skel))
        {
            resetMFR();
            return;
        }

        $("#wghtSkel").html(skel.toFixed(1));

        var organs = (skel * 1.5);

        if (isNaN(organs))
        {
            resetMFR();
            return;
        }

        $("#wghtOrgans").html(organs.toFixed(1));

        <?php if ($user->sex == 'M'): ?>
        var muscleMin = skel * 3.0;
        var muscleMax = skel * 4.0;
        <?php else: ?>
        var muscleMin = skel * 3.5;
        var muscleMax = skel * 4.75;
        <?php endif ?>

        if (isNaN(muscleMin))
        {
            resetMFR();
            return;
        }

        $("#wghtMusclMin").html(muscleMin.toFixed(1));
        $("#wghtMusclMax").html(muscleMax.toFixed(1));

        var minWeight = Math.round(skel + organs + muscleMin);
        var maxWeight = Math.round(skel + organs + muscleMax);

        $("#wghtMin").html(minWeight);
        $("#wghtMax").html(maxWeight);
    }
</script>