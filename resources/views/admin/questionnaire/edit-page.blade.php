@extends('user-layout-without-panel')

@section('title')
Ändra enkätsida
@stop

@section('page-header')
Ändra enkätsida
@stop

@section('content')
    {{ Form::open(array('action' => array("QuestionnairePageController@postEdit", $id), "class" => "info-form")) }}

    {{ Form::label('label', 'Namn *') }} <span>{{ $errors->first('label') }}<br>
    {{ Form::text('label', $label) }}<br>

    {{ Form::label('description', 'Beskrivning') }}<br>
    {{ Form::textarea('description', $description) }}<br>

    {{ Form::submit('Ändra') }} <a href="{{ url('/admin/questionnaire/pages') }}" class="back-link">Avbryt</a>

    {{ Form::close() }}
@stop