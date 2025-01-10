@extends('user-layout-without-panel')

@section('title')
Ny enkätsida
@stop

@section('page-header')
Ny enkätsida
@stop

@section('content')
    {{ Form::open(array('action' => "QuestionnaireAdminController@postNew", 'class' => 'info-form new-questionnaire-page-form')) }}

    {{ Form::label('label', 'Namn *') }} <span>{{ $errors->first('label') }}<br>
    {{ Form::text('label') }}<br>

    {{ Form::label('description', 'Beskrivning') }}<br>
    {{ Form::textarea('description') }}<br>

    {{ Form::submit('Skapa') }} <a href="{{ url('/admin/questionnaire/pages') }}" class="back-link">Avbryt</a>

    {{ Form::close() }}
@stop