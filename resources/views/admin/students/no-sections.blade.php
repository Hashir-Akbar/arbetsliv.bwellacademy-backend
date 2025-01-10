@extends('user-layout-without-panel')

@section('page-header')
{{ __('nav.students') }}
@stop

@section('content')
    @if (config('fms.type') == 'work')
        <h2>Det här företaget har inte några avdelningar. <a href="{{ url('/admin/units/' . $unit_id . '/new/division') }}">Lägg till avdelning</a></h2>
    @else
        <h2>Den här skolan har inte några klasser. <a href="{{ url('/admin/units/' . $unit_id . '/new/class') }}">Lägg till klass</a></h2>
    @endif
@stop
