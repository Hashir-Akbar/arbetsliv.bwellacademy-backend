@extends('user-layout-with-panel')

@section('page-header')
{{ __('general.welcome') }}
@stop

@section('content')
@if ($user->isStudent())
<div class="actions">
    @php
    $profile = $user->latestProfile();
    @endphp
    <div class="intro">
        @if (!is_null($profile) && $profile->completed)
            <p>
                Nu är det dags för en uppföljande Livsstilsplan. Det kommer att gå till på precis samma sätt som när du gjorde den förra.
                Först fystester (om du valt det) sedan frågor som du svarar på och till sist en ny Livsstilsplan.
            </p>
        @else
            @if (config('fms.type') == 'work')
                <p>
                    Välkommen {{ $user->first_name }} till Bwell som ska hjälpa dig att bestämma hur du vill ha ditt
                    <strong>F</strong>ysiska, <strong>M</strong>entala och <strong>S</strong>ociala liv framöver.
                </p>
                <p>
                    Du ska nu skapa din egen Livsstilsplan som ska leda dig mot ditt önskade liv.
                </p>
                <p>
                    Först erbjuds du om du vill att göra ett antal enkla fysiska tester av din rörlighet, styrka, hållning, motorik, balans och kondition.
                    Sedan följer ett antal frågor om hur du tränar, upplever din hälsa, dina matvanor, Alkohol och tobaksvanor, din fritid och hur du tycker det fungerar i arbetet.
                </p>
                <p>
                    Du äger själv din Bwell livsstilsplan. Ingen annan än du själv och din sköterska ser dina resultat.
                </p>
            @else
                <p>
                    Välkommen {{ $user->first_name }} till Bwell som ska hjälpa dig att bestämma hur du vill ha ditt
                    <strong>F</strong>ysiska, <strong>M</strong>entala och <strong>S</strong>ociala liv framöver.
                </p>
                <p>
                    Du ska nu skapa din egen Livsstilsplan som ska leda dig mot ditt önskade liv.
                </p>
                <p>
                    Först erbjuds du om du vill att göra ett antal enkla fysiska tester av din rörlighet, styrka, hållning, motorik, balans och kondition.
                    Sedan följer ett antal frågor om hur du tränar, upplever din hälsa, dina matvanor, Alkohol och tobaksvanor, din fritid och hur du tycker det fungerar i skolan.
                </p>
                <p>
                    Du äger själv din Bwell livsstilsplan. Ingen annan än du själv och din skolsköterska ser dina resultat.
                </p>
            @endif
        @endif
        <p>
            <a href="{{ url('profile/page/1') }}">Klicka här när du vill börja.</a>
        </p>
    </div>
</div>
@endif
<div class="grid">
    <div class="grid-profile grid-header">
        @if ($user->isStudent())
        <div class="profile-tile element-click-area pink" style="cursor: auto">
            <h4 class="element-title" style="color:white">FMS<br><strong>F</strong>ysisk styrka, <strong>M</strong>ental harmoni och <strong>S</strong>ocial förmåga</h4>
        </div>
        @endif
    </div>
    <?php $i = 0; ?>
    @foreach (App\Tile::all() as $tile)
        @if ($i % 3 === 2)
        <div class="grid-element right">
        @else
        <div class="grid-element">
        @endif
            <a href="{{ url('/profile/page/' . $tile['page']) }}" class="element-click-area">
                <span class="element-picture">
                    <img src="{{ asset('images/icons/' . $tile['icon'] . '-big.png') }}" alt="{{ __($tile['label']) }}">
                </span>
                <h4 class="element-title">{{ __($tile['label']) }}</h4>
            </a>
        </div>
        <?php $i++; ?>
    @endforeach
    @if ($user->isStudent())
    <div class="grid-element grid-profile">
        <a class="profile-tile element-click-area pink" href="{{ url('/statement/results') }}">
            <h4 class="element-title">{{ __('sidebar.results') }}</h4>
        </a>
    </div>
    @endif
</div>
@stop
