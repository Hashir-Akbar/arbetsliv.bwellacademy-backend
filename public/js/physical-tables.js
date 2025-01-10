(function () {
    if (typeof mock === "undefined") {
        stepTableEstimation();
        bikeTableEstimation();

        $("#question-bicycle .desc-table th.pulse").qtip({
            prerender: true,
            content: {
                text: $("#pulse-table-container").clone(),
            },
            position: {
                my: "bottom right",
                at: "top center",
                selector: $(".desc-table th.pulse"),
            },
        });

        $("#question-step .desc-table th.pulse").qtip({
            prerender: true,
            content: {
                text: $("#pulse-table-container").clone(),
            },
            position: {
                my: "bottom right",
                at: "top center",
                selector: $(".desc-table th.pulse"),
            },
        });

        $("#question-bicycle .desc-table th.borg").qtip({
            prerender: true,
            content: {
                text: $("#borg-table-container").clone(),
            },
            position: {
                my: "bottom right",
                at: "top center",
                selector: $(".desc-table th.borg"),
            },
        });

        $("#question-step .desc-table th.borg").qtip({
            prerender: true,
            content: {
                text: $("#borg-table-container").clone(),
            },
            position: {
                my: "bottom right",
                at: "top center",
                selector: $(".desc-table th.borg"),
            },
        });
    }

    function convertBorgToIndex(value) {
        if (value < 6) return 0;
        else if (value < 8) return 1;
        else if (value < 10) return 2;
        else if (value < 12) return 3;
        else if (value < 14) return 4;
        else if (value < 16) return 5;
        else if (value < 18) return 6;
        else return 7;
    }

    function convertPulseToIndex(pulse, age) {
        if (pulse < 60 || pulse > 199) return 0;

        if (age < 0) return 0;

        var pulseMatrix = [
            [1, 1, 1, 1, 1, 1, 1, 1, 1],
            [1, 1, 1, 1, 1, 1, 1, 1, 2],
            [2, 2, 2, 2, 2, 2, 2, 2, 2],
            [2, 2, 2, 3, 3, 3, 3, 3, 3],
            [3, 3, 3, 3, 3, 3, 3, 4, 4],
            [3, 3, 4, 4, 4, 4, 4, 4, 4],
            [4, 4, 4, 4, 4, 5, 5, 5, 5],
            [4, 4, 5, 5, 5, 5, 5, 6, 6],
            [5, 5, 5, 5, 6, 6, 6, 6, 7],
            [5, 6, 6, 6, 6, 6, 7, 7, 7],
            [6, 6, 6, 6, 7, 7, 7, 7, 7],
            [6, 7, 7, 7, 7, 7, 7, 7, 7],
            [7, 7, 7, 7, 7, 7, 7, 7, 7],
        ];

        var pulseIndexes = [60, 70, 80, 90, 100, 110, 120, 130, 140, 150, 160, 170, 180];

        var ageIndexes = [0, 26, 31, 36, 41, 46, 51, 56, 61];

        var pulseIdx = pulseIndexes.length;
        while (pulseIndexes[--pulseIdx] > pulse) {}

        var ageIdx = ageIndexes.length;
        while (ageIndexes[--ageIdx] > age) {}

        return pulseMatrix[pulseIdx][ageIdx];
    }

    function stepTableEstimation() {
        var borg = parseInt($("#fitBorgSteady").val());
        var pulse = parseInt($("#fitPulseSteady").val());

        if (!isNaN(borg)) {
            $(".desc-table.step .borg.value").removeClass("value");
            var b = convertBorgToIndex(borg);
            $(".desc-table.step .row-" + b + " .borg").addClass("value");
        } else {
            $(".desc-table.step .borg.value").removeClass("value");
        }

        if (!isNaN(pulse)) {
            $(".desc-table.step .pulse.value").removeClass("value");
            var age = parseInt($("#userAge").val());
            var p = convertPulseToIndex(pulse, age);
            if (p > 0)
                $(".desc-table.step .row-" + p + " .pulse").addClass("value");
        } else {
            $(".desc-table.step .pulse.value").removeClass("value");
        }

        var fitMaxEst = "";
        if (b !== undefined && p !== undefined) {
            if (Math.abs(b - p) <= 1) {
                fitMaxEst = 0;
            } else {
                fitMaxEst = -1;
            }
        }

        $("#fitMaxEst").val(fitMaxEst);

        // if (typeof sendValue !== "undefined")
        // {
        //     sendValue({"name": "fitMaxEst", "value": fitMaxEst}, $("#fitMaxEst"), false);
        // }
    }

    $(".step-table select").on("change", stepTableEstimation);
    $(".step-table input").on("keyup", stepTableEstimation);

    function bikeTableEstimation() {
        var borg = parseInt($("#fitBicBorgSteady").val());
        var pulse = parseInt($("#fitBicPulseSteady").val());

        if (!isNaN(borg)) {
            $(".desc-table.bike .borg.value").removeClass("value");
            var b = convertBorgToIndex(borg);
            $(".desc-table.bike .row-" + b + " .borg").addClass("value");
        } else {
            $(".desc-table.bike .borg.value").removeClass("value");
        }

        if (!isNaN(pulse)) {
            $(".desc-table.bike .pulse.value").removeClass("value");
            var age = parseInt($("#userAge").val());
            var p = convertPulseToIndex(pulse, age);
            if (p > 0)
                $(".desc-table.bike .row-" + p + " .pulse").addClass("value");
        } else {
            $(".desc-table.bike .pulse.value").removeClass("value");
        }

        var fitBicEst = "";
        if (b !== undefined && p !== undefined) {
            if (Math.abs(b - p) <= 1) {
                fitBicEst = 0;
            } else {
                fitBicEst = -1;
            }
        }

        $("#fitBicEst").val(fitBicEst);

        // if (typeof sendValue !== "undefined")
        // {
        //     sendValue({"name": "fitBicEst", "value": fitBicEst}, $("#fitBicEst"), false);
        // }
    }

    $(".bike-table select").on("change", bikeTableEstimation);
    $(".bike-table input").on("keyup", bikeTableEstimation);
})();
