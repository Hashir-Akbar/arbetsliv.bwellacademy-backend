@extends('user-layout-without-panel')

@section('page-header')
Ny personal till {{ $unit->name }}
@stop

@section('styles')
<link rel="stylesheet" href="{{ asset('/vendor/sumoselect-3.0.2/sumoselect.css') }}">
@stop

@section('content')
{{ Form::open(array('action' => array('StaffController@postNew', $unit->id), 'class' => 'info-form new-staff-form')) }}

    @if ($errors->has('first_name'))
    <span class="errors">{{ $errors->first('first_name') }}</span>
    @endif
    <label for="first_name">Förnamn *</label>
    <input type="text" name="first_name" value="{{ Request::old('first_name') }}" required><br>

    @if ($errors->has('last_name'))
    <span>{{ $errors->first('last_name') }}</span>
    @endif
    <label for="last_name">Efternamn *</label>
    <input type="text" name="last_name" value="{{ Request::old('last_name') }}" required><br>

    @if ($errors->has('email'))
    <span>{{ $errors->first('email') }}</span>
    @endif
    <label for="email">Emailadress *</label>
    <input type="text" name="email" value="{{ Request::old('email') }}" required><br>

    <label for="roles">Roller</label><br>
    <select id="roles" name="roles[]" multiple="multiple">
        <option value="admin" {{ in_array('admin', Request::old('roles') ?? []) ? 'selected="selected"' : '' }}>{{ __('roles.staff') }}</option>
        @if ($currentUser->isSuperAdmin())
            <option value="nurse" {{ in_array('nurse', Request::old('roles') ?? []) ? 'selected="selected"' : '' }}>{{ __('roles.nurse') }}</option>
            <option value="physical_trainer" {{ in_array('physical_trainer', Request::old('roles') ?? []) ? 'selected="selected"' : '' }}>{{ __('roles.physical_trainer') }}</option>
        @else
            <option value="nurse" {{ in_array('nurse', Request::old('roles') ?? []) ? 'selected="selected"' : '' }} disabled="disabled">{{ __('roles.nurse') }}</option>
            <option value="physical_trainer" {{ in_array('physical_trainer', Request::old('roles') ?? []) ? 'selected="selected"' : '' }} disabled="disabled">{{ __('roles.physical_trainer') }}</option>
        @endif
    </select>

    <p>
        {{ Form::submit('Skapa', array('class' => 'btn')) }}

        <a class="back-link" href="{{ url('/admin/staff?unit=' . $unit->id) }}">Avbryt</a>
    </p>

{{ Form::close() }}

<script src="{{ asset('/vendor/sumoselect-3.0.2/jquery.sumoselect.min.js') }}"></script>
<script>
    $(window).ready(function() {
        $("#roles").SumoSelect({
            placeholder: "Välj",
            captionFormat: "{0} valda",
            captionFormatAllSelected: "Alla valda",
        });
    });
</script>
@stop
