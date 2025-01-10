@extends('user-layout-without-panel')

@section('title')
Ändra klass
@stop

@section('page-header')
Ändra klass
@stop

@section('content')
    {{ Form::open(array('action' => array('SectionController@postEdit', 'id' => $id), 'class' => 'info-form edit-class-form')) }}

        <input type="checkbox" name="completed" {{ $section->completed ? 'checked="checked"' : '' }}>
        <label for="completed">Avslutad</label><br>

        {{ Form::label('name', 'Namn') }} <span>{{ $errors->first('name') }}</span><br>
        {{ Form::text('name', $section->name) }}<br>
        
        {{ Form::label('school_year', 'Årskurs') }}<br>
        <select name="school_year" id="school_year">
            <?php
            if ($section->unit->school_type == 'unit.primary') {
                $years = 9;
            } else {
                $years = 4;
            }
            ?>
            @for ($i = 1; $i <= $years; $i++)
                <?php
                if ($section->unit->school_type == 'unit.primary') {
                    $label = $i;
                } else {
                    $label = "GY" . $i;
                }
                ?>
                @if ($section->school_year == $i)
                <option value="{{ $i }}" selected="selected">{{ $label }}</option>
                @else
                <option value="{{ $i }}">{{ $label }}</option>
                @endif
            @endfor
        </select> 
        <span>{{ $errors->first('school_year') }}</span>
        <br>
        
        @if ($section->unit->school_type != 'unit.primary')
        {{ Form::label('program', 'Program') }}<br>
        <select name="program" id="program">
            <option value="0">Inget</option>
            @foreach ($programs as $program)
                @if ($section->program_id == $program->id)
                <option value="{{ $program->id }}" selected="selected">{{ $program->label }}</option>
                @else
                <option value="{{ $program->id }}">{{ $program->label }}</option>
                @endif
            @endforeach
        </select>
        <br>
        @endif

        {{ Form::submit('Ändra', array('class' => 'btn')) }}

        <a class="back-link" href="{{ url('/admin/sections?unit=' . $section->unit_id) }}">Avbryt</a>

    {{ Form::close() }}
@stop
