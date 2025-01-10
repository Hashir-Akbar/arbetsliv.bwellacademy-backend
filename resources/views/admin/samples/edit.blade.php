@extends('user-layout-without-panel')

@section('title')
Ändra urvalsgrupp
@stop

@section('page-header')
Ändra urvalsgrupp
@stop

@section('content')
    {{ Form::open(array('action' => array('SamplesController@postEdit', $id), 'class' => 'info-form edit-sample-form')) }}
        {{ Form::label('name', 'Namn') }} <span>{{ $errors->first('name') }}</span><br>
        {{ Form::text('name', $name, array('required' => 'required')) }}<br>

        {{ Form::submit('Ändra', array('class' => 'btn')) }} <a class="back-link" href="{{ url('/admin/samples') }}">Avbryt</a>
    {{ Form::close() }}
@stop