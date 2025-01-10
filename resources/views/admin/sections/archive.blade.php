@extends('user-layout-without-panel')

@section('page-header')
@if (config('fms.type') == 'work')
    Arkivera avdelning
@else
    Arkivera klass
@endif
@stop

@section('content')
    {{ Form::open(array('action' => array('SectionController@postArchive', $id), 'class' => 'info-form remove-section-form')) }}

        <p>
            Är du säker på att du vill ta arkivera <em>{{ $section->name }}</em>?
        </p>

        {{ Form::submit('Arkivera', array('class' => 'btn')) }}

        <a class="back-link" href="{{ url('/admin/sections?unit=' . $section->unit_id) }}">Avbryt</a>

    {{ Form::close() }}
@stop