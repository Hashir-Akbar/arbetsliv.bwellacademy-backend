@extends('user-layout-without-panel')

@section('page-header')
Ändra personal
@stop

@section('styles')
<link rel="stylesheet" href="{{ asset('/vendor/sumoselect-3.0.2/sumoselect.css') }}">
@stop

@section('content')
{{ Form::open(array('action' => array('StaffController@postEdit', $user->id), 'class' => 'info-form edit-staff-form')) }}

    @if ($errors->has('first_name'))
    <span class="errors">{{ $errors->first('first_name') }}</span>
    @endif
    <label for="first_name">Förnamn *</label>
    <input type="text" name="first_name" value="{{ $user->first_name }}" required><br>

    @if ($errors->has('last_name'))
    <span>{{ $errors->first('last_name') }}</span>
    @endif
    <label for="last_name">Efternamn *</label>
    <input type="text" name="last_name" value="{{ $user->last_name }}" required><br>

    @if ($errors->has('email'))
    <span>{{ $errors->first('email') }}</span>
    @endif
    <label for="email">Emailadress *</label>
    <input type="text" name="email" value="{{ $user->email }}" required><br>

    <label for="roles">Roller</label><br>
    <select id="roles" name="roles[]" multiple="multiple">
        <option value="admin" {{ $user->is_admin ? 'selected="selected"' : '' }}>{{ __('roles.staff') }}</option>
        @if ($currentUser->isSuperAdmin())
            <option value="nurse" {{ $user->is_nurse ? 'selected="selected"' : '' }}>{{ __('roles.nurse') }}</option>
            <option value="physical_trainer" {{ $user->is_physical_trainer ? 'selected="selected"' : '' }}>{{ __('roles.physical_trainer') }}</option>
        @else
            <option value="nurse" {{ $user->is_nurse ? 'selected="selected"' : '' }} disabled="disabled">{{ __('roles.nurse') }}</option>
            <option value="physical_trainer" {{ $user->is_physical_trainer ? 'selected="selected"' : '' }} disabled="disabled">{{ __('roles.physical_trainer') }}</option>
        @endif
    </select>

    <p>
        {{ Form::submit('Spara', array('class' => 'btn')) }}

        <a class="back-link" href="{{ url('/admin/staff?unit=' . $unit->id) }}">Avbryt</a>
    </p>
{{ Form::close() }}

@if(is_null($user->deactivated_at))
    {{ Form::open(array('action' => array('StaffController@postDeactivate', $user->id), 'class' => 'info-form edit-staff-form')) }}
        <h4 style="margin: 0 0 10px;">
            Aktivt konto
        </h4>

        <p>
            {{ Form::submit('Inaktivera konto', array('class' => 'btn')) }}
        </p>
    {{ Form::close() }}
@else
    {{ Form::open(array('action' => array('StaffController@postActivate', $user->id), 'class' => 'info-form edit-staff-form')) }}
        <h4 style="margin: 0 0 10px;">
            Inaktivt konto
        </h4>

        <p>
            {{ Form::submit('Aktivera konto', array('class' => 'btn')) }}
        </p>
    {{ Form::close() }}
@endif

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
