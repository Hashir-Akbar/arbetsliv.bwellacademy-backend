@extends('user-layout-without-panel')

@section('title')
Ändra användare
@stop

@section('page-header')
Välj kön
@stop

@section('content')
<div class="page">
    <h3 class="questionnaire-page-title">För att undersökningen ska bli korrekt måste du välja kön.</h3>

    {{ Form::open(array('url' => '/setsex', 'method' => 'post', 'class' => 'info-form edit-user-form'))  }}

    {{ Form::label('sex', 'Kön' . ' *') }} <span>{{ $errors->first('sex') }}</span><br>
    <select name="sex" id="sex">
        <option value="M" {{ $user->sex == 'M' ? 'selected="selected"' : ''}}>{{ __("general.male") }}</option>
        <option value="F" {{ $user->sex == 'F' ? 'selected="selected"' : ''}}>{{ __("general.female") }}</option>
    </select><br>

    {{ Form::hidden('user_id', $user->id) }}

    {{ Form::submit('Spara', array('class' => 'btn')) }} <a class="back-link" href="{{ url('/users') }}">Avbryt</a>

    {{ Form::close() }}
</div><!-- end page -->

@stop