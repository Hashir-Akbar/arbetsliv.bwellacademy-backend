@extends('user-layout-without-panel')

@section('page-header')
{{ __('nav.students') }}
@stop

@section('content')
    @if (config('fms.type') == 'work')
        <h2>Du har inget företag.</h2>
    @else
        <h2>Du har ingen skola.</h2>
    @endif
@stop
