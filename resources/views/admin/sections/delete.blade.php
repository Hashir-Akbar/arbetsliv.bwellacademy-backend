@extends('user-layout-without-panel')

@section('page-header')
@if (config('fms.type') == 'work')
    Ta bort avdelning
@else
    Ta bort klass
@endif
@stop

@section('content')
    {{ Form::open(array('action' => array('SectionController@postDelete', $id), 'class' => 'info-form remove-section-form')) }}

        <p>
            Är du säker på att du vill ta bort <em>{{ $section->name }}</em>?
        </p>

        {{ Form::submit('Ta bort', array('class' => 'btn')) }} 

        <a class="back-link" href="{{ url('/admin/sections?unit=' . $section->unit_id) }}">Avbryt</a>
        
    {{ Form::close() }}
@stop