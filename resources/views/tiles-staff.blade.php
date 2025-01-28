@extends('user-layout-without-panel')

@section('page-header')
Välkommen {{ $user->full_name() }}
@stop

@section('content')
<div class="container">
    <div class="filters" style="background-color: white;">
        <select class="dropdown" style="background-color: white;" id="sectionDropdown">
            <option value="">
                Välj Avdelning
            </option>
            <?php foreach ($sections as $iterSection): ?>
                <option value="<?= $iterSection->unit_id.".".$iterSection->id ?>" <?= $iterSection->id == optional($section ?? null)->id ? 'selected' : '' ?>>
                    <?= $iterSection->full_name() ?>
                </option>
            <?php endforeach; ?>
        </select>

    </div>
    <div class="charts-container" style="margin-bottom: 20px;">
        <div class="chart-card" style="display: flex; align-items: center; justify-content: space-between;">
            <div style="width: 30%;">
                <h3 class="chart-title">Anställda</h3>
                <canvas id="donutChart"></canvas>
            </div>
            <div style="width: 60%;">
                <h3 class="chart-title ">Users by Category</h3>
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    <canvas id="physicalChart" width="400" height="200"></canvas>
    <canvas id="wellbeingChart" width="400" height="200"></canvas>
    <canvas id="antChart" width="400" height="200"></canvas>
    <canvas id="energyChart" width="400" height="200"></canvas>
    <canvas id="freetimeChart" width="400" height="200"></canvas>
    <canvas id="workChart" width="400" height="200"></canvas>
    <canvas id="kasamChart" width="400" height="200"></canvas>

</div>

<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .filters {
        display: flex;
        justify-content: flex-start;
        gap: 15px;
        margin-bottom: 20px;
    }

    .dropdown {
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .charts-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: flex-start;
    }

    .chart-card {
        flex: 1 1 calc(50% - 20px);
        background: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        text-align: left;
    }

    .chart-title {
        font-size: 18px;
        font-weight: bold;
        color: #3276fb;
        margin-bottom: 15px;
    }

    .chart-subtitle {
        font-size: 14px;
        color: #6B7280;
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        .charts-container {
            flex-direction: column;
        }

        .chart-card {
            flex: 1 1 100%;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    let chartInstances = [];

    function fetchDataAndRenderCharts(selectedSectionId) {

    chartInstances.forEach(chart => chart.destroy());
    chartInstances = [];

    $.ajax(fms_url + "/statistics/filter/set", {
        dataType: "json",
        method: "post",
        data: selectedSectionId ? { section: selectedSectionId } : {}, // Send data only if a section is selected
        success: function (response) {
            console.log(response);
            if (!response || Object.keys(response).length === 0) {
                // Clear the chart area and show a message
                document.querySelector('.charts-container').innerHTML = `
                    <div class="empty">
                        @if (App::isLocale('sv'))
                        <h2>Det här urvalet har inga {{ config('fms.type') == 'work' ? 'anställda' : 'elever' }}</h2>
                        <h4>Använd filtreringsmenyn för att välja ett annat urval.</h4>
                        @else
                        <h2>This selection does not have any {{ config('fms.type') == 'work' ? 'employees' : 'students' }}</h2>
                        <h4>Use the filter menu to change selection.</h4>
                        @endif
                    </div>
                `;
                return;
            }

            // Reset the charts container to its original state
            document.querySelector('.charts-container').innerHTML = `
                <div class="chart-card" style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="width: 30%;">
                        <h3 class="chart-title">Anställda</h3>
                        <canvas id="donutChart"></canvas>
                    </div>
                    <div style="width: 60%;">
                        <h3 class="chart-title ">Users by Category</h3>
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            `;



        
            numMen = response.numMen ?? 0;
            numWomen = response.numWomen ?? 0;

            const donutCtx = document.getElementById('donutChart').getContext('2d');
            const donutChart = new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: [`Male (n=${numMen})`, `Female (n=${numWomen})`],
                    datasets: [{
                        data: [numMen, numWomen],
                        backgroundColor: ['#3276fb', '#f75895'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#3276fb',
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(2);
                                return ` ${percentage}%`;
                            }
                        }
                    }
                    }
                }
            });
            chartInstances.push(donutChart);

            riskMen = response.riskGroupMen?.risk ?? 0;
            friskMen = response.riskGroupMen?.healthy ?? 0;
            warningMen = response.riskGroupMen?.warning ?? 0;

            riskWomen = response.riskGroupWomen?.risk ?? 0;
            friskWomen = response.riskGroupWomen?.healthy ?? 0;
            warningWomen = response.riskGroupWomen?.warning ?? 0;

            const barCtx = document.getElementById('barChart').getContext('2d');
            const barChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['Risk', 'Frisk', 'Warning'],
                    datasets: [
                        {
                            label: 'Male',
                            data: [riskMen, friskMen, warningMen],
                            backgroundColor: '#3276fb',
                            borderRadius: 5,
                        },
                        {
                            label: 'Female',
                            data: [riskWomen, friskWomen, warningWomen],
                            backgroundColor: '#f75895',
                            borderRadius: 5,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#3276fb',
                                font: {
                                    size: 14
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    color: '#e5e7eb'
                                },
                                ticks: {
                                    stepSize: 20
                                }
                            }
                        }
                    }
                }
            });

            chartInstances.push(barChart);

            createChart('physicalChart', Object.values(response.mappedLabels.physical ?? {}), Object.values(response.mappedValues.physical ?? {}));
            createChart('wellbeingChart', Object.values(response.mappedLabels.wellbeing ?? {}), Object.values(response.mappedValues.wellbeing ?? {}));
            createChart('antChart', Object.values(response.mappedLabels.ant ?? {}), Object.values(response.mappedValues.ant ?? {}));
            createChart('energyChart', Object.values(response.mappedLabels.energy ?? {}), Object.values(response.mappedValues.energy ?? {}));
            createChart('freetimeChart', Object.values(response.mappedLabels.freetime ?? {}), Object.values(response.mappedValues.freetime ?? {}));
            createChart('workChart', Object.values(response.mappedLabels.work ?? {}), Object.values(response.mappedValues.work ?? {}));
            createChart('kasamChart', Object.values(response.mappedLabels.kasam ?? {}), Object.values(response.mappedValues.kasam ?? {}));

        }
    });



    // Function to create a chart
    function createChart(chartId, labels, values) {
        const ctx = document.getElementById(chartId).getContext('2d');
        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Risk',
                        data: values.map(v => v[0]),
                        backgroundColor: '#f34f98',
                    },
                    {
                        label: 'Healthy',
                        data: values.map(v => v[1]),
                        backgroundColor: '#3276fb',
                    },
                    {
                        label: 'Warning',
                        data: values.map(v => v[2]),
                        backgroundColor: '#7AC143',
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.dataset.label || '';
                                const value = context.raw;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(2);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: {
                            color: '#e5e7eb'
                        },
                        ticks: {
                            stepSize: 20
                        }
                    }
                }
            }
        });
        chartInstances.push(chart);

    }}

    window.addEventListener('load', function() {
        const initialSectionId = document.getElementById('sectionDropdown').value;
        fetchDataAndRenderCharts(initialSectionId);
    });

    document.getElementById('sectionDropdown').addEventListener('change', function() {
        const selectedSectionId = this.value;
        fetchDataAndRenderCharts(selectedSectionId);
    });

</script>
@stop