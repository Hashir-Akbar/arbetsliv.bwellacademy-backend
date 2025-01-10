@extends('user-layout-without-panel')

@section('title')
Ny frågegrupp
@stop

@section('page-header')
Ny frågegrupp
@stop

@section('content')
    {{ Form::open(array('action' => array("QuestionnaireGroupsController@postNew", $page_id), 'class' => 'info-form new-questionnaire-group-form')) }}

    @if ($errors->has('label'))
    <p class="errors">{{ $errors->first('label') }}</p>
    @endif
    {{ Form::label('label', 'Namn *') }}<br>
    {{ Form::text('label') }}<br>

    <label for="type">Grupptyp</label>
    <select id="type" name="type">
        @foreach ($groupTypes as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select><br>

    {{ Form::submit('Skapa', array('class' => 'btn')) }}
    <a class="back-link" href="{{ url('/admin/questionnaire/pages') }}">Avbryt</a>

    {{ Form::close() }}
@stop