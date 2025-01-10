@extends('user-layout-without-panel')

@section('title')
Ny frågegrupp
@stop

@section('page-header')
Ny frågegrupp
@stop

@section('content')
    {{ Form::open(array('action' => "QuestionnaireGroupsController@postNew")) }}
    {{ Form::hidden('page_id', $page_id) }}

    {{ Form::label('label', 'Namn *') }} <span>{{ $errors->first('label') }}<br>
    {{ Form::text('label') }}<br>

    {{ Form::submit('Skapa') }} <a href="{{ url('/admin/questionnaire/pages') }}" class="back-link">Avbryt</a>

    {{ Form::close() }}
@stop