@extends('user-layout-without-panel')

@section('title')
Ta bort enkätsida
@stop

@section('page-header')
Ta bort enkätsida
@stop

@section('content')
    {{ Form::open(array('action' => array('QuestionnairePageController@postDelete', $id), 'class' => 'info-form remove-questionnaire-page-form')) }}

        <p>
            Är du säker på att du vill ta bort enkätsidan {{ $name }}?
        </p>

        {{ Form::submit('Ta bort', array('class' => 'btn')) }} <a class="back-link" href="{{ url('/admin/questionnaire/pages') }}">Avbryt</a>
        
    {{ Form::close() }}
@stop