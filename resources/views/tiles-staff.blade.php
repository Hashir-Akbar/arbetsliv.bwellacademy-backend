@extends('user-layout-without-panel')

@section('page-header')
Välkommen {{ $user->full_name() }}
@stop

@section('content')
<div class="container">
    <div class="filters" style="background-color: white;">
        <select class="dropdown" style="background-color: white;">
            <option>Company</option>
            <option>Company A</option>
            <option>Company B</option>
        </select>
        <select class="dropdown" style="background-color: white;">
            <option>Department</option>
            <option>HR</option>
            <option>Engineering</option>
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

    <div class="charts-container">
        @for ($i = 1; $i <= 5; $i++)
        <div class="chart-card" style="flex: 1 1 100%;">
            <h3 class="chart-title">Additional Bar Chart {{ $i }}</h3>
            <canvas id="additionalBarChart{{ $i }}"></canvas>
        </div>
        @endfor
    </div>
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

    $.ajax(fms_url + "/statistics/filter/set", {
        dataType: "json",
        method: "post",
        success: function (response) {
            console.log(response);

            numMen = response.numMen;
            numWomen = response.numWomen;

            const donutCtx = document.getElementById('donutChart').getContext('2d');
            new Chart(donutCtx, {
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

            riskMen = response.riskGroupMen.risk;
            friskMen = response.riskGroupMen.healthy;
            warningMen = response.riskGroupMen.warning;

            riskWomen = response.riskGroupWomen.risk;
            friskWomen = response.riskGroupWomen.healthy;
            warningWomen = response.riskGroupWomen.warning;

            const barCtx = document.getElementById('barChart').getContext('2d');
            new Chart(barCtx, {
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

        }
    });
    

    

    @for ($i = 1; $i <= 5; $i++)
    const additionalBarCtx{{ $i }} = document.getElementById('additionalBarChart{{ $i }}').getContext('2d');
    new Chart(additionalBarCtx{{ $i }}, {
        type: 'bar',
        data: {
            labels: ['Segment A', 'Segment B', 'Segment C', 'Segment D', 'Segment E', 'Segment F', 'Segment G', 'Segment H', 'Segment I', 'Segment J', 'Segment K', 'Segment L', 'Segment M', 'Segment N', 'Segment O'],
            datasets: [
                {
                    label: 'Data Set 1',
                    data: Array.from({length: 15}, () => Math.floor(Math.random() * 100)),
                    backgroundColor: '#3276fb',
                    borderRadius: 5,
                },
                {
                    label: 'Data Set 2',
                    data: Array.from({length: 15}, () => Math.floor(Math.random() * 100)),
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
    @endfor
</script>
@stop