(function () {
    window.womenChart = null;
    window.menChart = null;
    window.combinedChart = null;
    window.barChart = null;

    var fillColorRisk = "#f34f98";
    var fillColorHealthy = "#7FE563";
    var fillColorWarning = "#7AC143";
    var fillColorunknown = "#FFFFFF";

    window.doughnut = function (
        numWomen,
        numMen,
        riskGroupMen,
        riskGroupWomen
    ) {
        numWomen =
            riskGroupWomen.risk +
            riskGroupWomen.warning +
            riskGroupWomen.healthy;
        numMen =
            riskGroupMen.risk + riskGroupMen.warning + riskGroupMen.healthy;
        var total = numWomen + numMen;

        $(".num-women").html(numWomen);
        $(".num-men").html(numMen);
        $(".num-all").html(total);

        var riskGroupAllRisk = riskGroupMen.risk + riskGroupWomen.risk;
        var riskGroupAllHealthy = riskGroupMen.healthy + riskGroupWomen.healthy;
        var riskGroupAllWarning = riskGroupMen.warning + riskGroupWomen.warning;

        if (total > 0) {
            $(".risk-all").html(
                riskGroupAllRisk +
                    " (" +
                    Math.round((riskGroupAllRisk / total) * 100) +
                    "%)"
            );
            $(".healthy-all").html(
                riskGroupAllHealthy +
                    " (" +
                    Math.round((riskGroupAllHealthy / total) * 100) +
                    "%)"
            );
            $(".warning-all").html(
                riskGroupAllWarning +
                    " (" +
                    Math.round((riskGroupAllWarning / total) * 100) +
                    "%)"
            );
        } else {
            $(".risk-all").html(riskGroupAllRisk);
            $(".healthy-all").html(riskGroupAllHealthy);
            $(".warning-all").html(riskGroupAllWarning);
        }

        if (numWomen > 0) {
            $(".risk-women").html(
                riskGroupWomen.risk +
                    " (" +
                    Math.round((riskGroupWomen.risk / numWomen) * 100) +
                    "%)"
            );
            $(".healthy-women").html(
                riskGroupWomen.healthy +
                    " (" +
                    Math.round((riskGroupWomen.healthy / numWomen) * 100) +
                    "%)"
            );
            $(".warning-women").html(
                riskGroupWomen.warning +
                    " (" +
                    Math.round((riskGroupWomen.warning / numWomen) * 100) +
                    "%)"
            );
        } else {
            $(".risk-women").html(riskGroupWomen.risk);
            $(".healthy-women").html(riskGroupWomen.healthy);
            $(".warning-women").html(riskGroupWomen.warning);
        }

        if (numMen > 0) {
            $(".risk-men").html(
                riskGroupMen.risk +
                    " (" +
                    Math.round((riskGroupMen.risk / numMen) * 100) +
                    "%)"
            );
            $(".healthy-men").html(
                riskGroupMen.healthy +
                    " (" +
                    Math.round((riskGroupMen.healthy / numMen) * 100) +
                    "%)"
            );
            $(".warning-men").html(
                riskGroupMen.warning +
                    " (" +
                    Math.round((riskGroupMen.warning / numMen) * 100) +
                    "%)"
            );
        } else {
            $(".risk-men").html(riskGroupMen.risk);
            $(".healthy-men").html(riskGroupMen.healthy);
            $(".warning-men").html(riskGroupMen.warning);
        }
    };

    window.chartData = {};

    window.factorChart = function (pages, labels, values, factorMap) {
        //console.log(values);
        chartData["pages"] = pages;
        chartData["factorMap"] = factorMap;

        var riskDataset = {
            label: "Risk",
            title: "Risk",
            fillColor: fillColorRisk,
            strokeColor: fillColorRisk,
            highlightFill: fillColorRisk,
            highlightStroke: fillColorRisk,
            data: [],
            realData: [],
        };

        var healthyDataset = {
            label: "Frisk",
            title: "Frisk",
            fillColor: fillColorHealthy,
            strokeColor: fillColorHealthy,
            highlightFill: fillColorHealthy,
            highlightStroke: fillColorHealthy,
            data: [],
            realData: [],
        };

        var count = 0;
        var biggestTotal = 0;
        var strippedLabels = [];
        for (var factor in labels) {
            var label = labels[factor];
            strippedLabels.push(label);
            var val = values[factor];

            var healthy = val[0];
            var risk = val[1];
            var warning = val[2];

            var total = healthy + risk + warning; // Add warning
            if (total > biggestTotal) {
                biggestTotal = total;
            }
            var healthyPer = (healthy / total) * 100;
            var riskPer = (risk / total) * 100;

            riskDataset.data.push(riskPer);
            healthyDataset.data.push(healthyPer);

            riskDataset.realData.push(total);
            healthyDataset.realData.push(total);

            count++;
        }

        strippedLabels.reverse();

        riskDataset.data.reverse();
        healthyDataset.data.reverse();

        riskDataset.realData.reverse();
        healthyDataset.realData.reverse();

        var barData = {
            labels: strippedLabels, //.reverse(),
            datasets: [healthyDataset, riskDataset],
        };

        var numberPad = 0;
        if (biggestTotal >= 10000) {
            numberPad = 20;
        } else if (biggestTotal >= 1000) {
            numberPad = 10;
        } else if (biggestTotal >= 100) {
            numberPad = 5;
        }

        //faktorer chart
        var barOptions = {
            legend: true,
            barShowStroke: false,
            barValueSpacing: 0,
            barDatasetSpacing: 0,
            inGraphDataShow: true,
            inGraphDataFontFamily: "ProximaNova",
            inGraphDataFontColor: "#ffffff",
            inGraphDataTmpl:
                "<% if (!isNaN(v6) && v6 !== 0 && (v6 > 10 || v6 % 1 == 0)) {%><%= v6 %>%<%}%>", //"<% if (v3 === 0) {%>Okänd<%} else if (v3 < 3) {%>Risk<%} else {%>Frisk<%}%>",
            scaleFontStyle: "normal",
            scaleOverride: true,
            scaleSteps: 10,
            scaleStartValue: 0,
            scaleStepWidth: 10,
            xAxisBottom: true,
            xAxisFontSize: 12,
            xAxisFontStyle: "italic",
            xAxisLabel: "Antal %",
            paddingRight: numberPad,
            onAnimateFrame: window.createFactorChart,
        };

        var selector = "#factorChart";

        var height = 0;
        var pagesLength = pages.length;
        for (var i = 0; i < pagesLength; i++) {
            var barsCount = factorMap[pages[i]].length;
            height += barsCount * 23;
            height += 10;
            height += 30;
        }

        height += 35;

        ChartNewJsWorkaround(
            selector + "-container",
            selector.substring(1),
            "650",
            getChartHeight(count)
        );
        factorChartDest.canvas.height = height;
        var ctx = $(selector).get(0).getContext("2d");

        //console.log(barData);

        var chart = new Chart(ctx).HorizontalStackedBar(barData, barOptions);
    };

    if (window.fms_lang == "en") {
        window.pageLabels = {
            physical: "Physical capacity",
            wellbeing: "Experienced health",
            ant: "ANDT",
            energy: "Food and energy",
            freetime: "Life at leisuretime",
            school: "Life in school",
            work: "Life at work",
            kasam: "SOC",
        };
    } else {
        window.pageLabels = {
            physical: "Fysisk kapacitet",
            wellbeing: "Upplevd hälsa",
            ant: "ANDT",
            energy: "Mat och energi",
            freetime: "Livet på fritiden",
            school: "Livet i skolan",
            work: "Livet på arbetet",
            kasam: "KASAM",
        };
    }

    function getDate() {
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        return (
            d.getFullYear() +
            (month < 10 ? "0" : "") +
            month +
            (day < 10 ? "0" : "") +
            day
        );
    }

    $(function () {
        var link = document.getElementById("save-factor-image");
        link.addEventListener(
            "click",
            function () {
                var canvas = makeSerializedFactorChart();
                link.href = canvas.toDataURL();
                link.download = "fms_statistik_" + getDate() + ".png";
            },
            false
        );
    });

    function makeSerializedChart(oldCtx) {
        var oldCanvas = oldCtx.canvas;

        var newCanvas = document.createElement("canvas");
        var newCtx = newCanvas.getContext("2d");

        var oldWidth = oldCanvas.width;
        var oldHeight = oldCanvas.height;
        var margin = 200;
        var leftPadding = 15;

        var filters = serializeFiltersForChart();

        newCanvas.height = oldHeight;
        newCanvas.width = oldWidth;
        printFilters = false;
        if (filters.length > 0) {
            newCanvas.width += margin;
            printFilters = true;
        }

        newCtx.clearRect(0, 0, newCanvas.width, newCanvas.height);

        newCtx.fillStyle = "white";
        newCtx.fillRect(0, 0, newCanvas.width, newCanvas.height);

        newCtx.drawImage(
            oldCanvas,
            0,
            0,
            oldWidth,
            oldHeight,
            0,
            0,
            oldWidth,
            oldHeight
        );

        if (printFilters) {
            newCtx.font = "18px ProximaNova";
            newCtx.textBaseline = "top";
            newCtx.textAlign = "left";

            var x = oldWidth + leftPadding;
            var y = 0;

            newCtx.fillText("Urval", x, y);
            y += 24;

            newCtx.font = "14px ProximaNova";

            var filterLength = filters.length;
            for (var i = 0; i < filterLength; i++) {
                var f = filters[i];
                if (f.name == "categories") {
                    continue;
                }

                newCtx.fillText(f.nameLabel + ": " + f.valueLabel, x, y);
                y += 18;
            }
        }

        return newCanvas;
    }

    function makeSerializedFactorChart() {
        return makeSerializedChart(factorChartDest);
    }

    window.factorChartDest = $("#cutDest").get(0).getContext("2d");

    window.createPagedChart = function (originalCtx, destination) {
        destination.font = "18px ProximaNova";
        destination.textBaseline = "top";

        var oW = originalCtx.canvas.width * window.devicePixelRatio;

        function getBars(num, numSkip) {
            var barHeight = 23;
            var margins = 10;
            var skip = barHeight * numSkip;
            if (skip > 0) skip += margins;
            var bars = barHeight * num;
            if (skip == 0) bars += margins;
            return [
                bars * window.devicePixelRatio,
                skip * window.devicePixelRatio,
            ];
        }

        destination.clearRect(
            0,
            0,
            destination.canvas.width,
            destination.canvas.height
        );

        var cdpages = chartData["pages"];
        var cdfactmap = chartData["factorMap"];

        var skip = 0;
        var cdplen = cdpages.length;
        var y = 0;
        for (var i = 0; i < cdplen; i++) {
            var barCount = cdfactmap[cdpages[i]].length;

            if (barCount == 0) continue;

            destination.fillText(pageLabels[cdpages[i]], 0, y);
            if (skip > 0) {
                y += 30;
            } else {
                y += 20;
            }

            var barsInfo = getBars(barCount, skip);
            skip += barCount;

            var heightBars = barsInfo[0];
            var heightSkip = barsInfo[1];

            destination.drawImage(
                originalCtx.canvas,
                0,
                heightSkip,
                oW,
                heightBars,
                0,
                y,
                oW / window.devicePixelRatio,
                heightBars / window.devicePixelRatio
            );

            y += heightBars / window.devicePixelRatio + 10;
        }

        //y += 35;

        destination.drawImage(
            originalCtx.canvas,
            0,
            originalCtx.canvas.height - 35 * window.devicePixelRatio,
            oW,
            35 * window.devicePixelRatio,
            0,
            y,
            oW / window.devicePixelRatio,
            35
        );
    };

    window.createFactorChart = function (originalCtx) {
        createPagedChart(originalCtx, factorChartDest);
    };
})();
