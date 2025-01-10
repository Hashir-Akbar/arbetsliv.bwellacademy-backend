function compareAltCharts(selector, counter, dataLabel, values, titles) {
    var labels = dataLabel;

    var labelSet = [];

    var fillColorRisk = "#f34f98";
    var fillColorHealthy = "#7FE563";
    var fillColorWarning = "#7AC143";

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

    var warningDataset = {
        label: "Varning",
        title: "Varning",
        fillColor: fillColorWarning,
        strokeColor: fillColorWarning,
        highlightFill: fillColorWarning,
        highlightStroke: fillColorWarning,
        data: [],
        realData: [],
    };

    var count = 0;
    var biggestTotal = 0;

    for (var key in labels) {
        var val = values[key];

        if (val == undefined) {
            val = [0, 0, 0];
        }

        if (val[2] == undefined) {
            val[2] = 0;
        }
        // console.log(val);
        var healthy = val[0];
        var risk = val[1];
        var warning = val[2];

        var total = healthy + risk + warning;
        if (total > biggestTotal) {
            biggestTotal = total;
        }
        var healthyPer = (healthy / total) * 100;
        var riskPer = (risk / total) * 100;
        var warningPer = (warning / total) * 100;

        riskDataset.data.push(riskPer);
        healthyDataset.data.push(healthyPer);
        warningDataset.data.push(warningPer);

        riskDataset.realData.push(total);
        healthyDataset.realData.push(total);
        warningDataset.realData.push(total);
        labelSet.push(labels[key]);

        count++;
    }

    labelSet.reverse();

    riskDataset.data.reverse();
    healthyDataset.data.reverse();
    warningDataset.data.reverse();

    riskDataset.realData.reverse();
    healthyDataset.realData.reverse();
    warningDataset.realData.reverse();

    var barData = {
        labels: labelSet,
        datasets: [healthyDataset, warningDataset, riskDataset],
    };

    var numberPad = 5;
    if (biggestTotal >= 10000) {
        numberPad = 20;
    } else if (biggestTotal >= 1000) {
        numberPad = 15;
    } else if (biggestTotal >= 100) {
        numberPad = 5;
    }

    if (counter > 0) {
        var yAxisLeft = false;
        var drawWidth = 280;
    } else {
        var yAxisLeft = true;
        var drawWidth = 400;
    }

    var title = titles[counter];

    if (title.length > 35) {
        title = title.replace("Klass ", "");
        title = title.substring(0, 35) + "...";
    }

    var barOptions = {
        legend: false,
        barShowStroke: false,
        barValueSpacing: 0,
        barDatasetSpacing: 0,
        inGraphDataShow: true,
        inGraphDataFontFamily: "ProximaNova",
        inGraphDataFontColor: "#ffffff",
        inGraphDataTmpl:
            "<% if (!isNaN(v6) && v6 !== 0 && (v6 > 10)) {%><%= v6 %>%<%}%>", //"<% if (v3 === 0) {%>Okänd<%} else if (v3 < 3) {%>Risk<%} else {%>Frisk<%}%>",
        scaleFontStyle: "normal",
        scaleOverride: true,
        scaleSteps: 10,
        scaleStartValue: 0,
        scaleStepWidth: 10,
        scaleShowLabels: true,
        xAxisBottom: false,
        xAxisFontSize: 12,
        xAxisFontStyle: "italic",
        xAxisLabel: "Antal %",
        paddingRight: 20,
        graphTitle: title,
        graphTitleFontSize: 13,
        yAxisFontColor: "white",
        yAxisLeft: yAxisLeft,
        yAxisRight: false,
        // onAnimateFrame: window.createSchoolChart,
    };

    var canvasObj = selector + counter;

    var height = count * 20;
    height += 75;

    //ChartNewJsAppend("#compare-factors-container", selector, "400", getChartHeight(count));
    ChartNewJsAppend("#" + selector, canvasObj, drawWidth, height);
    // schoolFactorChartDest.canvas.height = height;
    var ctx = $("#" + canvasObj)
        .get(0)
        .getContext("2d");

    var chart = new Chart(ctx).HorizontalStackedBar(barData, barOptions);
}
