@extends('user-layout-without-panel')

@section('title')
Statistik
@stop

@section('page-header')
Statistik
@stop

@section('styles')
<link rel="stylesheet" href="{{ asset(version('/css/statistics.css')) }}">
@stop

@section('content')
    @if (App::isLocale('sv'))
        <h2>Det här urvalet har inga {{ config('fms.type') == 'work' ? 'anställda' : 'elever' }}</h2>
        <h4>Använd filtreringsmenyn för att välja ett annat urval.</h4>
    @else
        <h2>This selection does not have any {{ config('fms.type') == 'work' ? 'employees' : 'students' }}</h2>
        <h4>Use the filter menu to change selection.</h4>
    @endif
@stop
