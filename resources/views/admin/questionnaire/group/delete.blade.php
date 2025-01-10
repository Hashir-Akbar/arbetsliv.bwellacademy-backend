@extends('user-layout-without-panel')

@section('title')
Ta bort frågegrupp
@stop

@section('page-header')
Ta bort frågegrupp
@stop

@section('content')
    {{ Form::open(array('action' => array('QuestionnaireGroupsController@postDelete', $id), 'class' => 'info-form delete-questionnaire-group-form')) }}

        <p>
            Är du säker på att du vill ta bort frågegruppen {{ $name }}?<br>
            Alla frågor som tillhör den här gruppen kommer att försvinna.
        </p>

        {{ Form::submit('Ta bort', array('class' => 'btn')) }} <a class="back-link" href="{{ url('/admin/questionnaire/pages') }}">Avbryt</a>
        
    {{ Form::close() }}
@stop