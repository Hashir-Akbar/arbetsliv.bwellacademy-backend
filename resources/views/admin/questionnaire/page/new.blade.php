@extends('user-layout-without-panel')

@section('title')
Ny enkätsida
@stop

@section('page-header')
Ny enkätsida
@stop

@section('content')
    {{ Form::open(array('action' => "QuestionnairePageController@postNew", 'class' => 'info-form new-questionnaire-page-form')) }}

    @if ($errors->has('label'))
    <p class="errors">{{ $errors->first('label') }}</p>
    @endif
    {{ Form::label('label', 'Namn *') }}<br>
    {{ Form::text('label') }}<br>

    {{ Form::label('description', 'Beskrivning') }}<br>
    {{ Form::textarea('description') }}<br>
    <input type="checkbox" id="show_description" name="show_description">
    <label for="show_description">Visa beskrivning</label><br>

    {{ Form::submit('Skapa', array('class' => 'btn')) }}
    <a class="back-link" href="{{ url('/admin/questionnaire/pages') }}">Avbryt</a>

    {{ Form::close() }}
@stop