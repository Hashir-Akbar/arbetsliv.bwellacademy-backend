@extends('base')

@section('body')
<div class="site-main">
        <div class="head">
            @include('_top', ['user' => Auth::user()])
            @include('_mobile-nav')
        </div>
        <div class="content">
            @include('_sidebar')
            <div class="content-body has-sidepanel">
                <h1 class="page-header grey">
                    @yield('page-header')
                </h1>
                <div class="inner{{ isset($cssClasses) ? ' ' . $cssClasses : '' }} no-forms">
                    <div class="spinner dimscreen">
                        @if (App::isLocale('sv'))
                        <span class="dimtext"><img src="{{ asset('images/ajax.GIF') }}" alt="Laddar..."> Laddar statistik...</span>
                        @else
                        <span class="dimtext"><img src="{{ asset('images/ajax.GIF') }}" alt="Loading..."> Loading statistics...</span>
                        @endif
                    </div>
                @yield('content')
                </div>
            </div>
            @include('statistics._filter', ['businessCategories' => $businessCategories])
        </div>
    </div>
@stop