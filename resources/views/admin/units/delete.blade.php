@extends('user-layout-without-panel')

@section('page-header')
@if (config('fms.type') == 'work')
    Ta bort företag
@else
    Ta bort skola
@endif
@stop

@section('content')
    {{ Form::open(array('action' => array('UnitController@postDelete', $id), 'class' => 'info-form delete-unit-form')) }}

        <p>
            Är du säker på att du vill ta bort <em>{{ $unit->name }}</em>?
        </p>

        {{ Form::submit('Ta bort', array('class' => 'btn')) }} <a class="back-link" href="{{ url('/admin/units') }}">Avbryt</a>
        
    {{ Form::close() }}
@stop