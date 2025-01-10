@extends('user-layout-without-panel')

@section('title')
Ta bort medlem från urvalsgrupp
@stop

@section('page-header')
Ta bort medlem från urvalsgrupp
@stop

@section('content')
    {{ Form::open(array('action' => array('SamplesController@postRemoveMember', $sample->id, $user->id), 'class' => 'remove-sample-member-form')) }}

        <p>
            Är du säker på att du vill ta bort {{ $user->full_name() }} från gruppen {{ $sample->label }}?
        </p>

        {{ Form::submit('Ta bort', array('class' => 'btn')) }} <a class="back-link" href="{{ url('/admin/samples/' . $sample->id . '/members') }}">Avbryt</a>
    {{ Form::close() }}
@stop