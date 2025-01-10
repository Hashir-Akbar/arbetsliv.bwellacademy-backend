@extends('user-layout-without-panel')

@section('page-header')
Ny klass
@stop

@section('content')
{{ Form::open(array('action' => array('SectionController@postNew', 'unit_id' => $unit->id), 'class' => 'info-form new-class-form')) }}
    <span>{{ $errors->first('name') }}</span>
    {{ Form::label('name', 'Namn') }}<br>
    {{ Form::text('name', Request::old('name')) }}<br>
    
    <span>{{ $errors->first('school_year') }}</span>
    {{ Form::label('school_year', 'Årskurs') }}<br>
    <select name="school_year" id="school_year">
        @if ($unit->school_type == 'unit.primary')
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        @else
        <option value="1">GY1</option>
        <option value="2">GY2</option>
        <option value="3">GY3</option>
        <option value="4">GY4</option>
        @endif
    </select>
    <br>
    
    @if ($unit->school_type == 'unit.secondary')
    {{ Form::label('program', 'Program') }}<br>
    <select name="program" id="program">
        <option value="0">Inget</option>
        @foreach ($programs as $program)
            <option value="{{ $program->id }}">{{ $program->label }}</option>
        @endforeach
    </select>
    <br>
    @endif

    {{ Form::submit('Skapa', array('class' => 'btn')) }}

    <a class="back-link" href="{{ url('/admin/sections?unit=' . $unit->id) }}">Avbryt</a>
{{ Form::close() }}
@stop