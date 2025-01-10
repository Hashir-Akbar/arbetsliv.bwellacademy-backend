@extends('user-layout-without-panel')

@section('title')
Ta bort urvalsgrupp
@stop

@section('page-header')
Ta bort urvalsgrupp
@stop

@section('content')
    {{ Form::open(array('action' => array('SamplesController@postDelete', $id), 'class' => 'info-form delete-sample-form')) }}

        <p>
            Är du säker på att du vill ta bort urvalsgruppen {{ $name }}?
        </p>

        {{ Form::submit('Ta bort', array('class' => 'btn')) }} <a class="back-link" href="{{ url('/admin/samples') }}">Avbryt</a>

    {{ Form::close() }}
@stop