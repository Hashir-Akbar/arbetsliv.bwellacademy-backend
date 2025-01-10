@extends('user-layout-without-panel')

@section('title')
Ändra avdelning
@stop

@section('page-header')
Ändra avdelning
@stop

@section('content')
    {{ Form::open(array('action' => array('SectionController@postEdit', 'id' => $id), 'class' => 'info-form edit-division-form')) }}

        {{ Form::label('name', 'Namn') }} <span>{{ $errors->first('name') }}</span><br>
        {{ Form::text('name', $section->name) }}<br>

        {{ Form::submit('Ändra', array('class' => 'btn')) }}
        
        <a class="back-link" href="{{ url('/admin/sections?unit=' . $section->unit_id) }}">Avbryt</a>

    {{ Form::close() }}
@stop
