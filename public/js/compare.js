(function () {
    window.colors = [
        "#BF3E78",
        "#5B89A8",
        "#7F2950",
        "#689CBF",
        "#FF53A0",
        "#45687F",
        "#401528",
        "#8AD0FF",
        "#F34F98",
        "#233440",
    ];

    window.factorLabels = [];
    window.compareValues = {};

    window.combinedValues = {};
    window.combinedLabels = [];

    window.getColor = function (i) {
        return colors[i % colors.length];
    };

    $(document).ready(function () {
        $("#compare-factors-save-link").click(function (ev) {
            ev.preventDefault();

            var imgData;

            var showView = $("input[name='comparesite']:checked").val();

            if (showView == "multiple") {
                var ctx = createCanvas(compareValues, factorLabels);
                //var ctx = createCanvas(window.combinedValues, window.combinedLabels);
                imgData = ctx.canvas.toDataURL();
            } else {
                var combImg = [];
                $("#compare-factors-container")
                    .children("canvas")
                    .each(function () {
                        var ctx = $(this)[0].getContext("2d");

                        combImg.push(ctx);
                    });

                var ctxComb = combineImages(combImg);
                imgData = ctxComb.canvas.toDataURL();
            }

            $.post(fms_url + "/request-image", { img: imgData }, function (
                response
            ) {
                setTimeout(function () {
                    window.open(response.url, "_blank");
                }, 200);
            });
        });
    });

    window.setCompareLabels = function (labels) {
        factorLabels = labels;
    };

    window.setCompareData = function (data) {
        var labels = [];
        var sexValuesM = [];
        var sexColorsM = [];
        var sexValuesF = [];
        var sexColorsF = [];
        var factorValues = [];

        var empty = 0;

        var length = data.length;
        for (var i = 0; i < length; i++) {
            var element = data[i];

            labels.push(element.name);

            var m = element.sexValues[1];
            var f = element.sexValues[0];
            var total = m + f;
            var perM = Math.round((m / total) * 1000) / 10;
            var perF = Math.round((f / total) * 1000) / 10;
            sexValuesM.push(perM);
            sexValuesF.push(perF);

            sexColorsM.push(getColor(1 + i * 2));
            sexColorsF.push(getColor(i * 2));

            factorValues.push({
                title: element.name,
                data: element.factorValues,
            });

            if (total == 0) empty++;
        }

        if (empty == length) {
            if ($(".inner .empty").hasClass("active")) {
                return;
            }

            $(".inner .active").fadeOut(window.FADE_SPEED, function (e) {
                $(this).removeClass("active");

                $(".inner .empty").fadeIn(window.FADE_SPEED, function () {
                    $(".inner .empty").addClass("active");
                });
            });

            return;
        }

        if (!$(".inner .multiple").hasClass("active")) {
            $(".inner .active").fadeOut(window.FADE_SPEED, function (e) {
                $(this).removeClass("active");

                $(".inner .multiple").fadeIn(window.FADE_SPEED, function () {
                    $(".inner .multiple").addClass("active");

                    showCharts(
                        labels,
                        sexValuesM,
                        sexValuesF,
                        sexColorsM,
                        sexColorsF,
                        factorLabels,
                        factorValues
                    );
                });
            });
        } else {
            showCharts(
                labels,
                sexValuesM,
                sexValuesF,
                sexColorsM,
                sexColorsF,
                factorLabels,
                factorValues
            );
        }
    };

    function showCharts(
        labels,
        sexValuesM,
        sexValuesF,
        sexColorsM,
        sexColorsF,
        factorLabels,
        factorValues
    ) {
        var showView = $("input[name='comparesite']:checked").val();

        if (showView == "multiple") {
            compareSexChart(
                labels,
                sexValuesM,
                sexValuesF,
                sexColorsM,
                sexColorsF
            );
            window.compareValues = factorValues;
            compareFactorChart(
                "#compare-factors-container",
                factorValues,
                factorLabels
            );

            updateHeights();
        } else {
            compareSexChart(
                labels,
                sexValuesM,
                sexValuesF,
                sexColorsM,
                sexColorsF
            );
            window.compareValues = factorValues;
            // console.log("nu");
            // console.log(labels, factorLabels);

            showAltCharts(labels, factorLabels, factorValues);

            updateHeights();
        }
    }

    function showAltCharts(labels, factorLabels, factorValues) {
        var lablen = factorValues.length;
        // console.log("antal");
        // console.log(labels);

        //Skapa faktor diagrammen
        for (var i = 0; i < lablen; i++) {
            var divid = createDivElement(i, "");

            // console.log("skapade:" + divid);

            compareAltCharts(
                "compare-factors-container",
                i,
                factorLabels,
                factorValues[i].data,
                labels
            );
        }
    }

    function createDivElement(counter, element) {
        var container = document.getElementById(element);
        var div = document.createElement("div");

        var divid = "comparechart" + counter;
        div.setAttribute("id", divid + "-container");

        //container.appendChild(div);

        return divid;
    }

    function compareSexChart(
        labels,
        datasetsM,
        datasetsF,
        sexColorsM,
        sexColorsF
    ) {
        ChartNewJsWorkaround(
            "#compare-students-m-container",
            "compareStudentsM",
            "460",
            getChartHeight(datasetsM.length)
        );
        var elem = $("#compareStudentsM");
        var ctx1 = elem.get(0).getContext("2d");

        ChartNewJsWorkaround(
            "#compare-students-f-container",
            "compareStudentsF",
            "460",
            getChartHeight(datasetsF.length)
        );
        var elem = $("#compareStudentsF");
        var ctx2 = elem.get(0).getContext("2d");

        var lcolors = colors.slice();

        var barOptions = {
            barShowStroke: false,
            showScale: true,
            scaleOverride: true,
            scaleSteps: 10,
            scaleStartValue: 0,
            scaleStepWidth: 10,
            scaleLabel: "<%= value %>%",
            annotateDisplay: true,
            annotateLabel: "<%= v2 %>: <%= v3 %>%",
        };

        var barDataM = {
            labels: labels,
            datasets: [
                {
                    title: "",
                    fillColor: sexColorsM,
                    strokeColor: sexColorsM,
                    data: datasetsM,
                },
            ],
        };

        var barDataF = {
            labels: labels,
            datasets: [
                {
                    title: "",
                    fillColor: sexColorsF,
                    strokeColor: sexColorsF,
                    data: datasetsF,
                },
            ],
        };

        var studentsChartM = new Chart(ctx1).HorizontalBar(
            barDataM,
            barOptions
        );
        var studentsChartF = new Chart(ctx2).HorizontalBar(
            barDataF,
            barOptions
        );
    }

    function compareFactorChart(selector, values, labelSet) {
        var barData = {
            labels: labelSet,
            datasets: [],
        };

        var length = values.length;
        for (var i = 0; i < length; i++) {
            var selection = values[i];

            var riskVals = [];
            var healthyVals = [];
            var warningVals = [];
            var riskPerVals = [];
            var healthPerVals = [];
            var warningPerVals = [];
            //var valLen = selection.data.length;

            var dataset = {
                title: selection.title,
                data: [],
                participants: [],
            };

            var labelSetNew = [];
            var counter = 0;

            // console.log(selection.data);
            for (var key in labelSet) {
                var val = selection.data[key];

                labelSetNew.push(labelSet[key]);

                counter++;

                var healthy = val[0];
                var risk = val[1];
                var warning = val[2];

                var total = healthy + risk + warning;
                var healthyPer = 0;
                var riskPer = 0;
                var warningPer = 0;
                if (total > 0) {
                    healthyPer = (healthy / total) * 100;
                    riskPer = (risk / total) * 100;
                    warningPer = (warning / total) * 100;
                }

                dataset.data.push([healthyPer, warningPer, riskPer]);
                dataset.participants.push(total);
            }
            barData.labels = labelSetNew;
            barData.datasets.push(dataset);
        }

        var datasetCount = barData.datasets.length;
        var numCategories = barData.labels.length;

        // Skapa markup yaaaaaay
        var baseTable = $(document.createElement("table"));
        baseTable.addClass("factors-table");

        for (var i = 0; i < numCategories; i++) {
            var category = barData.labels[i];
            var baseRow = $(document.createElement("tr"));
            baseRow.addClass("category-row");

            var titleCell = $(document.createElement("td"));
            titleCell.addClass("category-title").html(category);
            baseRow.append(titleCell);

            var barsCell = $(document.createElement("td"));
            barsCell.addClass("category-bars");

            var barsTable = $(document.createElement("table"));
            barsTable.addClass("selection-table");

            for (var j = 0; j < datasetCount; j++) {
                var dataset = barData.datasets[j];
                // console.log(dataset.data);

                var datasetRow = $(document.createElement("tr"));
                datasetRow.addClass("selection-row");

                var setTitleCell = $(document.createElement("td"));
                setTitleCell.addClass("selection-title");
                var setTitleDiv = $(document.createElement("div"));
                var title = dataset.title;
                if (title.length >= 23) {
                    title = title.substr(0, 20) + "...";
                }
                setTitleDiv.html(title);
                setTitleCell.append(setTitleDiv);

                var setValuesCell = $(document.createElement("td"));
                setValuesCell.addClass("selection-values");

                if (j == 0) {
                    setValuesCell.addClass("first");
                } else if (j + 1 == datasetCount) {
                    setValuesCell.addClass("last");
                }

                if (dataset.data.length > 0) {
                    var dsData = dataset.data[i];
                    var healthy = Math.round(dsData[0] * 10) / 10;
                    var warning = Math.round(dsData[1] * 10) / 10;
                    var risk = Math.round(dsData[2] * 10) / 10;

                    //console.log(dsData);
                    if (dsData == undefined) {
                        dsData = [0, 0, 0];
                    }
                    /*
                    var all = dsData[0] + dsData[1] + dsData[2];
                    var healthy = Math.round10((dsData[0] / all) * 100, -1);
                    var warning = Math.round10((dsData[1] / all) * 100, -1);
                    var risk = Math.round10((dsData[2] / all) * 100, -1);
                    */

                    var total = healthy + risk;
                    if (total != 100) {
                        warning = 100 - total;
                    } else {
                        warning = 0;
                    }

                    //healthy = healthy.toFixed(1);
                    warning = warning.toFixed(1);
                    //risk = risk.toFixed(2);

                    //var temp = healthy + warning + risk;
                    //var temp1 = temp - 100;

                    //risk = risk + temp1;

                    //alert("H: " + healthy + " W: " + warning + " R:" + risk);
                    //var risk = healthy + warning - 100;
                } else {
                    var healthy = 0;
                    var risk = 0;
                    var warning = 0;
                }

                var healthyDiv = $(document.createElement("div"));
                healthyDiv
                    .addClass("selection-bar")
                    .addClass("selection-healthy-bar")
                    .css("width", "0")
                    .data("value", healthy);

                var healthyPerSpan = $(document.createElement("span"));
                healthyPerSpan.addClass("selection-percentage");
                if (healthy > 8) healthyPerSpan.html(healthy + "%");
                healthyDiv.append(healthyPerSpan);

                var warningDiv = $(document.createElement("div"));
                warningDiv
                    .addClass("selection-bar")
                    .addClass("selection-warning-bar")
                    .css("width", "0")
                    .data("value", warning);

                var warningPerSpan = $(document.createElement("span"));
                warningPerSpan.addClass("selection-percentage");
                if (warning > 8) warningPerSpan.html(warning + "%");
                warningDiv.append(warningPerSpan);

                var riskDiv = $(document.createElement("div"));
                riskDiv
                    .addClass("selection-bar")
                    .addClass("selection-risk-bar")
                    .css("width", "0")
                    .data("value", risk);

                var riskPerSpan = $(document.createElement("span"));
                riskPerSpan.addClass("selection-percentage");
                if (risk > 4) riskPerSpan.html(risk + "%");
                else riskPerSpan.html("&nbsp;");
                riskDiv.append(riskPerSpan);

                setValuesCell.append(healthyDiv);
                setValuesCell.append(warningDiv);
                setValuesCell.append(riskDiv);

                var setParticipantsCell = $(document.createElement("td"));
                setParticipantsCell
                    .addClass("selection-participants")
                    .html(dataset.participants[i]);

                datasetRow.append(setTitleCell);
                datasetRow.append(setValuesCell);
                datasetRow.append(setParticipantsCell);
                barsTable.append(datasetRow);
            }

            barsCell.append(barsTable);
            baseRow.append(barsCell);
            baseTable.append(baseRow);
        }

        $(selector).empty().append(baseTable);

        setTimeout(function () {
            $(".selection-bar").each(function (_, e) {
                var $e = $(e);
                var value = $e.data("value");
                $e.css("width", value + "%");
            });
        }, 100);
    }

    function createCanvas(data, labels) {
        var lblLenght = 0;

        for (var key in labels) {
            lblLenght++;
        }

        //alert("D:"+data.length+" L:"+labels.length);
        var canvas = document.createElement("canvas");
        canvas.width = 720;
        canvas.height = data.length * lblLenght * 22; //1800;
        var ctx = canvas.getContext("2d");

        var fontSize = 14;
        var halfFontSize = Math.round(fontSize / 2);
        var marginBetweenDatasets = 2;

        ctx.font = fontSize + "px ProximaNova";
        ctx.textBaseline = "top";

        var participantsWidth = 40;
        var percentagePadding = 1;

        var datasets = [];

        var labelSet = [];

        var longestString = 0;
        var length = data.length;
        {
            for (var i = 0; i < length; i++) {
                var sel = data[i];
                var title = sel.title;
                if (title.length > 20) {
                    title = title.substring(0, 20) + "...";
                }
                var textWidth = ctx.measureText(title).width;
                if (textWidth > longestString) longestString = textWidth;
                var ds = {
                    title: title,
                    data: [],
                    participants: [],
                };
                //var selLen = sel.data.length;
                //for (var j = 0; j < selLen; j++) {
                for (var key in labels) {
                    var val = sel.data[key];
                    var healthy = val[0];
                    var risk = val[1];
                    var warning = val[2];
                    var total = healthy + risk + warning;
                    var healthyPer = 0;
                    var riskPer = 0;
                    var warningPer = 0;
                    if (total > 0) {
                        healthyPer = (healthy / total) * 100;
                        riskPer = (risk / total) * 100;
                        warningPer = (warning / total) * 100;
                    }
                    ds.data.push([healthyPer, warningPer, riskPer]);
                    ds.participants.push(total);
                    labelSet.push(labels[key]);
                }
                datasets.push(ds);
            }
        }

        var datasetCount = datasets.length;
        var datasetFontSize = datasetCount * (fontSize + marginBetweenDatasets);
        var halfOfDataset =
            Math.round(datasetFontSize / 2) -
            Math.round((fontSize + marginBetweenDatasets) / 2);
        var categoryCount = labelSet.length;

        var maxBarWidth = 380;

        var xBaseline = 150;
        var yBaseline = 10;
        for (var catIdx = 0; catIdx < categoryCount; catIdx++) {
            var category = labelSet[catIdx];

            for (var dsIdx = 0; dsIdx < datasetCount; dsIdx++) {
                var dataset = datasets[dsIdx];
                var y = yBaseline + dsIdx * (fontSize + marginBetweenDatasets);
                ctx.fillText(dataset.title, xBaseline, y);

                var x = xBaseline * 2;
                var healthy = 0;
                var healthyText = "";
                var healthyTextWidth = 0;
                var risk = 0;
                var riskText = "";
                var riskTextWidth = 0;
                if (dataset.data.length > 0) {
                    var dsData = dataset.data[catIdx];
                    if (dsData == undefined) {
                        dsData = [0, 0, 0];
                    }
                    healthy = Math.round(dsData[0] * 10) / 10;
                    healthyText = healthy + "%";
                    healthyTextWidth = ctx.measureText(healthyText).width;

                    warning = Math.round(dsData[1] * 10) / 10;
                    warningText = warning + "%";
                    warningTextWidth = ctx.measureText(warningText).width;

                    risk = Math.round(dsData[2] * 10) / 10;
                    riskText = risk + "%";
                    riskTextWidth = ctx.measureText(riskText).width;
                }

                var healthWidth = (healthy / 100) * maxBarWidth;
                var warningWidth = (warning / 100) * maxBarWidth;
                var riskWidth = (risk / 100) * maxBarWidth;

                if (healthWidth == 0 && riskWidth == 0) {
                    x += maxBarWidth;
                } else {
                    ctx.save();
                    ctx.font = "12px sans-serif";

                    ctx.fillStyle = "#7FE563";
                    ctx.fillRect(x, y, healthWidth, fontSize);
                    x += healthWidth;
                    ctx.fillStyle = "white";
                    if (healthy > 6) {
                        ctx.fillText(
                            healthy + "%",
                            x - healthyTextWidth - percentagePadding,
                            y + 2
                        );
                    }

                    ctx.fillStyle = "#7AC143";
                    ctx.fillRect(x, y, warningWidth, fontSize);
                    x += warningWidth;
                    ctx.fillStyle = "white";
                    if (warning > 6) {
                        ctx.fillText(
                            warning + "%",
                            x - warningTextWidth - percentagePadding,
                            y + 2
                        );
                    }

                    ctx.fillStyle = "#f34f98";
                    ctx.fillRect(x, y, riskWidth, fontSize);
                    x += riskWidth;
                    ctx.fillStyle = "white";
                    if (risk > 6) {
                        ctx.fillText(
                            risk + "%",
                            x - riskTextWidth - percentagePadding,
                            y + 2
                        );
                    }

                    ctx.restore();

                    x += maxBarWidth - (healthWidth + riskWidth + warningWidth);
                }
                ctx.fillText(dataset.participants[catIdx], x + 5, y);
            }
            ctx.fillText(category, 0, yBaseline + halfOfDataset);

            yBaseline += datasetCount * (fontSize + marginBetweenDatasets) + 8;

            ctx.save();
            ctx.beginPath();
            ctx.strokeStyle = "#EEE";
            ctx.moveTo(0, yBaseline - 6);
            ctx.lineTo(ctx.canvas.width, yBaseline - 6);
            ctx.stroke();
            ctx.strokeStyle = "#DDD";
            ctx.moveTo(300, 0);
            ctx.lineTo(300, ctx.canvas.height);
            ctx.stroke();
            ctx.moveTo(ctx.canvas.width - 39, 0);
            ctx.lineTo(ctx.canvas.width - 39, ctx.canvas.height);
            ctx.stroke();
            ctx.closePath();
            ctx.restore();
        }

        return ctx;
    }

    function combineImages(combImg) {
        var length = combImg.length;
        var width = 0;
        var height = 0;
        var x = 0;

        for (var i = 0; i < length; i++) {
            width += combImg[i].canvas.clientWidth;
            height = combImg[i].canvas.clientHeight;
        }

        var canvas = document.createElement("canvas");
        canvas.width = width;
        canvas.height = height;

        var ctx = canvas.getContext("2d");

        for (var i = 0; i < length; i++) {
            ctx.drawImage(combImg[i].canvas, x, 0);
            x += combImg[i].canvas.clientWidth;
        }

        return ctx;
    }

    function compareFactorChartChartNewJs(container, selector, values) {
        var barOptions = {
            legend: true,
            annotateDisplay: true,
            annotateLabel: "Antal <%= v1 %>: <%= v6 %>%",
            barShowStroke: false,
            inGraphDataShow: true,
            inGraphDataFontStyle: "ProximaNova",
            inGraphDataFontColor: "#fff",
            inGraphDataTmpl:
                "<% if (!isNaN(v6) && v6 !== 0 && (v6 > 10 || v6 % 1 == 0)) {%><%= v6 %>%<%}%>",
            multiTooltipTemplate: "<%= value %>%",
            scaleOverride: true,
            scaleSteps: 10,
            scaleStartValue: 0,
            scaleStepWidth: 10,
            xAxisBottom: true,
            xAxisFontSize: 12,
            xAxisFontStyle: "italic",
            xAxisLabel: "Antal %",
            paddingRight: 15,
        };

        var riskDatasetOld = {
            label: "Risk",
            title: "Risk",
            fillColor: "#f34f98",
            strokeColor: "#f34f98",
            highlightFill: "#f34f98",
            highlightStroke: "#f34f98",
            data: [],
            realData: [],
        };

        var healthyDatasetOld = {
            label: "Frisk",
            title: "Frisk",
            fillColor: "#6fac84",
            strokeColor: "#6fac84",
            highlightFill: "#6fac84",
            highlightStroke: "#6fac84",
            data: [],
            realData: [],
        };

        var barData = {
            labels: factorLabels,
            datasets: [
                //healthyDataset,
                //riskDataset
            ],
        };

        var length = values.length;
        for (var i = 0; i < length; i++) {
            var selection = values[i];

            var riskVals = [];
            var healthyVals = [];
            var riskPerVals = [];
            var healthPerVals = [];
            var valLen = selection.data.length;

            var dataset = {
                title: selection.title,
                data: [],
                participants: [],
            };

            for (var j = 0; j < valLen; j++) {
                var val = selection.data[j];

                var healthy = val[0];
                var risk = val[1];

                var total = healthy + risk;
                if (total == 0) {
                    var healthyPer = 0;
                    var riskPer = 0;
                } else {
                    var healthyPer = (healthy / total) * 100;
                    var riskPer = (risk / total) * 100;
                }

                dataset.data.push([healthyPer, riskPer]);
                dataset.participants.push(total);

                // riskPerVals.push(riskPer);
                // riskVals.push(total);

                // healthPerVals.push(healthyPer);
                // healthyVals.push(total);
            }

            barData.datasets.push(dataset);

            // riskDataset.data.push(riskPerVals);
            // riskDataset.realData.push(riskVals);

            // healthyDataset.data.push(healthPerVals);
            // healthyDataset.realData.push(healthyVals);
        }

        ChartNewJsWorkaround(
            container,
            selector.substring(1),
            "650",
            getChartHeight(factorLabels.length * length)
        );
        var ctx = $(selector).get(0).getContext("2d");

        var barChart = new Chart(ctx).HorizontalFactors(barData, barOptions);
    }
})();
