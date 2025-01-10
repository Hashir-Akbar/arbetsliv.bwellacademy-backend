@extends('statement.base')

@section('page-title')
{{ __('statement.unfinished-title') }}
@stop

@section('tab-contents')

<section>
    <p>För att komma vidare behöver du först avsluta livsstilsanalysen.</p>
    <p>Gå till <a href="{{ url('/statement/' . $profile->id . '/results') }}">Resultat livsstilsanalys</a>.</p>
</section>

@stop
