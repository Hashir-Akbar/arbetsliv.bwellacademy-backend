@extends('user-layout-without-panel')

@section('page-header')
Ta bort personal
@stop

@section('content')
    {{ Form::open(array('action' => array('StaffController@postDelete', $user->id), 'class' => 'info-form delete-staff-form')) }}

        <p>
            Är du säker på att du vill ta bort <em>{{ $user->full_name() }}</em>?
        </p>

        {{ Form::submit('Ta bort', array('class' => 'btn')) }} 
        
        <a class="back-link" href="{{ url('/admin/staff?unit=' . $unit->id) }}">Avbryt</a>
    {{ Form::close() }}
@stop
