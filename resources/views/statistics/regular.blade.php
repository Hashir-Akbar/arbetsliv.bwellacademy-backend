@extends('statistics.base')

@section('title')
{{ __('statistics.title') }}
@stop

@section('page-header')
{{ __('statistics.title') }} <small class="spinner"><img src="{{ asset('images/ajax.GIF') }}" alt="{{ __('statistics.loading') }}"> {{ __('statistics.loading') }}</small>
@stop

@section('styles')
<link rel="stylesheet" href="{{ asset('/vendor/sumoselect-3.0.2/sumoselect.css') }}">
<link rel="stylesheet" href="{{ asset(version('/css/statistics.css')) }}">
@stop

@section('content')
<h2 class="selection-title">{{ __('statistics.filter-type-school') }}</h2>
<div class="single">
     <section class="factors top_factors">
        <h4>{{ __('statistics.students') }}</h4>

        <div class="all top_data" >
            <h5>{{ __('statistics.all') }} <span class="count">(n=<span class="num-all"></span>)</span></h5>
            <h4>{{ __('statistics.healthy') }} <span class="healthy-all"></span></h4>
            <h4>{{ __('statistics.warning') }} <span class="warning-all"></span></h4>
            <h4>{{ __('statistics.risk') }} <span class="risk-all"></span></h4>
        </div>
        <div class="men top_data">
            <h5>{{ __('statistics.males') }} <span class="count">(n=<span class="num-men"></span>)</span></h5>
            <h4>{{ __('statistics.healthy') }} <span class="healthy-men"></span></h4>
            <h4>{{ __('statistics.warning') }} <span class="warning-men"></span></h4>
            <h4>{{ __('statistics.risk') }} <span class="risk-men"></span></h4>
        </div>
        <div class="women top_data">
            <h5>{{ __('statistics.females') }} <span class="count">(n=<span class="num-women"></span>)</span></h5>
            <h4>{{ __('statistics.healthy') }} <span class="healthy-women"></span></h4>
            <h4>{{ __('statistics.warning') }} <span class="warning-women"></span></h4>
            <h4>{{ __('statistics.risk') }} <span class="risk-women"></span></h4>
        </div>
     </section>

    <section class="factors">
        <h4>
            @if (App::isLocale('sv'))
            Livsstilsfaktorer
            <a id="save-factor-image" href="#" class="btn" style="margin-left: 40px;"><small>Spara som bild</small></a>
            <img id="save-factor-spinner" src="{{ asset('images/ajax.GIF') }}" alt="Laddar..." style="display:none"> 
            <a id="show-selection-people-link" href="#" target="_blank" class="btn"><small>Visa elever i urval</small></a>
            @else
            Lifestyle factors
            <a id="save-factor-image" href="#" class="btn" style="margin-left: 40px;"><small>Save as image</small></a>
            <img id="save-factor-spinner" src="{{ asset('images/ajax.GIF') }}" alt="Loading..." style="display:none"> 
            <a id="show-selection-people-link" href="#" target="_blank" class="btn"><small>Show students</small></a>
            @endif
        </h4>
        <!-- TODO: Vi vill kunna anpassa oss efter webbläsaren. -->
        <div id="factor-charts">
            <div id="factorChart-container" class="chart-container">
                <canvas id="factorChart" width="650" height="650"></canvas>
            </div>
            <canvas id="cutDest" width="650" height="650"></canvas>
        </div>
    </section>
</div>

<div class="multiple">
    <section class="students">
        <h3>{{ __('statistics.students') }}</h3>
        <div id="compare-students-m-container" class="compare-container">
            <h4>Killar</h4>
            <canvas id="compareStudentsM"></canvas>
        </div>
        <div id="compare-students-f-container" class="compare-container">
            <h4>Tjejer</h4>
            <canvas id="compareStudentsF"></canvas>
        </div>
    </section>
    <section class="factors">
        <h4>Faktorer <a href="#" class="btn" style="margin-left: 30px;" id="compare-factors-save-link"><small>Spara som bild</small></a></h4>
        <div id="compare-factors-container"></div>
    </section>
</div>

<div class="empty">
    @if (App::isLocale('sv'))
    <h2>Det här urvalet har inga {{ config('fms.type') == 'work' ? 'anställda' : 'elever' }}</h2>
    <h4>Använd filtreringsmenyn för att välja ett annat urval.</h4>
    @else
    <h2>This selection does not have any {{ config('fms.type') == 'work' ? 'employees' : 'students' }}</h2>
    <h4>Use the filter menu to change selection.</h4>
    @endif
</div>

<div class="compare-empty">
    @if (App::isLocale('sv'))
    <h2>De valda urvalen har inga {{ config('fms.type') == 'work' ? 'anställda' : 'elever' }}</h2>
    <h4>Använd filtreringsmenyn för att välja ett annat urval.</h4>
    @else
    <h2>These selections does not have any {{ config('fms.type') == 'work' ? 'employees' : 'students' }}</h2>
    <h4>Use the filter menu to change selection.</h4>
    @endif
</div>

<div class="empty-school">
    @if (config('fms.type') == 'work')
        @if (App::isLocale('sv'))
        <h2>Det här företaget har inte någon statistik</h2>
        <h4>Använd filtreringsmenyn för att välja ett annat urval.</h4>
        @else
        <h2>This company does not have any statistics</h2>
        <h4>Use the filter menu to change selection.</h4>
        @endif
    @else
        @if (App::isLocale('sv'))
        <h2>Den här skolan har inte någon statistik</h2>
        <h4>Använd filtreringsmenyn för att välja ett annat urval.</h4>
        @else
        <h2>This school does not have any statistics</h2>
        <h4>Use the filter menu to change selection.</h4>
        @endif
    @endif
</div>

<div class="initial active">
    <!--<h2>Laddar statistik... Detta kan ta upp till en minut</h2>-->
</div>

<script src="{{ asset('/vendor/chartnew/ChartNew.js') }}"></script>
<script src="{{ asset(version('/js/statistics.js')) }}"></script>
<script src="{{ asset(version('/js/compare.js')) }}"></script>
<script src="{{ asset(version('/js/compare-alt.js')) }}"></script>

<script>
    $(document).ready(function() {
        updateFilter();
    });
</script>

@stop