@extends('statement.base')

@section('page-title')
{{ __('statement.compare-title') }}
@stop

@section('tab-contents')
<section>
    <div class="profile-comparison">
        <h2>Jämför med profil {{ $otherProfile->date }}</h2>
        <div style="position: relative; width:500px; height:1500px;">
            <canvas id="profile-comparison-chart" width="500" height="1500"></canvas>
        </div>
    </div>
</section>

<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js') }}"></script>
<script>   
$(document).ready(function() {
    var labels = JSON.parse('<?= $labels ?>');
    var profileValues = JSON.parse('<?= $profileValues ?>');
    var otherProfileValues = JSON.parse('<?= $otherProfileValues ?>');

    var dataset1 = {
        label: 'Nulägesprofil',
        data: profileValues,
        backgroundColor: 'rgba(54, 162, 235, 1.0)',
        borderWidth: 0,
    };

    var dataset2 = {
        label: 'Jämförelseprofil',
        data: otherProfileValues,
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderWidth: 0,
    };

    var data = {
        labels: labels,
        datasets: [dataset1, dataset2],
    };

    var ctx = document.getElementById('profile-comparison-chart').getContext('2d');
    
    var myChart = new Chart(ctx, {
    type: 'horizontalBar',
        data: data,
        options: {
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    position: 'top',
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        max: 5,
                        callback: function(value) {
                            if (value === 0) {
                                return 'Inget värde';
                            }
                            if (value === 1) {
                                return '1 - Risk';
                            }
                            if (value === 5) {
                                return '5 - Frisk';
                            }
                            if (value % 1 === 0) {
                                return value;
                            }
                        },
                    },
                }],
            },
        },
    });
});
</script>
@stop
