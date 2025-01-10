@extends('user-layout-without-panel')

@section('page-header')
Ny avdelning
@stop

@section('content')
{{ Form::open(array('action' => array('SectionController@postNew', 'unit_id' => $unit->id), 'class' => 'info-form new-division-form')) }}
    <span>{{ $errors->first('name') }}</span>
    {{ Form::label('name', 'Namn') }}<br>
    {{ Form::text('name', Request::old('name')) }}<br>

    {{ Form::submit('Skapa', array('class' => 'btn')) }}

    <a class="back-link" href="{{ url('/admin/sections?unit=' . $unit->id) }}">Avbryt</a>
{{ Form::close() }}
@stop