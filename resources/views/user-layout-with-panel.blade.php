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
                <h1 class="page-header grey">@yield('page-header')</h1>
                @if (isset($pageWithForm))
                <div class="inner{{ isset($cssClasses) ? ' ' . $cssClasses : '' }} form-page">
                @else
                <div class="inner{{ isset($cssClasses) ? ' ' . $cssClasses : '' }} no-forms">
                @endif
                @yield('content')
                    <br clear="all">
                </div>
            </div>
            @include('_sidepanel', ['user' => Auth::user()])
        </div>
    </div>
@stop