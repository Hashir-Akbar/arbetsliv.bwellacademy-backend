@extends('statement.base')

@section('page-title')
{{ __('statement.results-title') }}
@stop

@section('tab-contents')

<section>
    @if (App::isLocale('sv'))
    <p>Klicka runt på tårtbitarna så får du en detaljerad beskrivning av ditt liv idag.</p>
    <p>Om du har fått en vit tårtbit beror det på att du valt att inte besvara en fråga inom området.<p>
    @else
    <p>You can click around to get a more detailed picture of what your life looks like today.</p>
    @endif
    <br>
    <div id="charts">
        <div class="chart-wrap">
            <div id="risk-factor-graph" hidden></div>
        </div>
        <div class="chart-wrap">
            <div id="detail-factor-graph" hidden></div>
        </div>
        <div class="chart-legend">
            @if (App::isLocale('sv'))
            <img src="{{ asset('images/legend_new.png') }}">
            @else
            <img src="{{ asset('images/legend_new_en.png') }}">
            @endif
        </div>
    </div>

    @if ($editable)
    <div id="autosave-info">
        {{ __('profile.autosave-info') }}
    </div>
    @endif

    <div class="button-container">
        @if ($mock)
            <a href="{{ url('/statement/mock/satisfied') }}" class="next-btn">{{ __('statement.btn-next') }}</a>
        @else
            @if ($isUsersProfile)
                @if ($profile->in_progress)
                    <a href="#finish" class="next-btn finish-profile">{{ __('statement.btn-finish-profile') }}</a>
                @else
                    <a href="{{ url('/statement/' . $profile->id . '/satisfied') }}" class="next-btn">{{ __('statement.btn-next') }}</a>
                @endif
            @else
                <a href="{{ url('/statement/' . $profile->id . '/plan') }}" class="next-btn">{{ __('statement.btn-next') }}</a>
            @endif
        @endif
    </div>
</section>

@if (!$mock)
<div id="finish" class="modal-dialog zoom-anim-dialog mfp-hide">
    <h2>Avsluta livsstilsanalysen</h2>
    <p>
        För att komma vidare behöver du först avsluta livsstilsanalysen. Därefter kommer du inte kunna ändra dina svar.
    </p>
    <form method="POST" action="{{ action('ProfileController@postFinish', $profile->id) }}">
        @csrf
        <input type="submit" class="next-btn" value="Avsluta livsstilsanalysen">
    </form>
</div>
@endif

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    window.profile_id = <?= $profile->id; ?>;
    window.editable = <?= $editable ? 'true' : 'false' ?>;
    window.mock = <?= $mock ? 'true' : 'false' ?>;

    window.mainChartData = JSON.parse({!! $mainChartData !!});

    $('.finish-profile').magnificPopup({
        type: 'inline',

        fixedContentPos: false,
        fixedBgPos: false,

        overflowY: 'auto',

        closeBtnInside: true,
        preloader: false,

        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in'
    });

    window.drawMainChart = function() {
        var mainData = window.mainChartData;

        colors = ['white', '#f34f98', '#ea6c99', '#1C8C22', '#7AC143', '#7FE563'];

        var options = {
            animation: {"startup": true},
            backgroundColor: 'transparent',
            legend: 'none',
            pieSliceBorderColor: '#000000',
            slices: {},
            pieSliceText: 'none',
            tooltip: {
                trigger: 'none',
                isHtml: false
            },
            legend: {
                position: 'labeled',
                textStyle: { color: '#5b89a8',
                            fontName: 'Arial',
                            fontSize: '10'
                    }
            },
            chartArea: {
                width: '90%',
                height: '90%'
            },
        };

        for(c in mainData['colors']) {
            var color = mainData['colors'][c];
            options.slices[c] = {color: color};
        }

        var mainGroupData = google.visualization.arrayToDataTable(mainData['slices']);

        var contMainGroup = document.getElementById("risk-factor-graph");
        var chartmaingroup = new google.visualization.PieChart(contMainGroup);

        $('#risk-factor-graph').show();

        chartmaingroup.draw(mainGroupData, options);


        google.visualization.events.addListener(chartmaingroup, 'select', function() {
            if (chartmaingroup.getSelection()[0] == null) {
                return;
            } else {
                selection = mainChartData.pages[chartmaingroup.getSelection()[0].row];

                window.drawMainFactors(profile_id, selection);
            }
           
        });
    };

    window.drawMainFactors = function(profile_id, page_id) {
        $.get(fms_url + "/statement/" + profile_id + "/factors/" + page_id, function(data){
            var factorData = JSON.parse(data);

            colors = ['white', '#f34f98', '#ea6c99', '#1C8C22', '#7AC143', '#7FE563'];

            var options = {
                animation: {"startup": true},
                backgroundColor: 'transparent',
                legend: 'none',
                pieSliceBorderColor: '#000000',
                slices: {},
                pieSliceText: 'none',
                tooltip: {
                    trigger: 'none', 
                    isHtml: false
                },
                legend: {
                    position: 'labeled',
                    textStyle: { color: '#5b89a8',
                                fontName: 'Arial',
                                fontSize: '10'
                        }
                },
                chartArea: {
                    width: '90%',
                    height: '90%'
                },
            };

            for(c in factorData['colors']) {
                var color = factorData['colors'][c];
                options.slices[c] = {color: color};
            }

            var slices = google.visualization.arrayToDataTable(factorData['slices']);

            var contDetails = document.getElementById("detail-factor-graph");
            var chartmaindetails = new google.visualization.PieChart(contDetails);

            $('#detail-factor-graph').show();

            chartmaindetails.draw(slices, options);
        });
    };

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(window.drawMainChart);
</script>
@stop
