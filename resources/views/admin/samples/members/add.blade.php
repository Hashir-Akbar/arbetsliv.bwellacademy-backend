@extends('user-layout-without-panel')

@section('page-header')
Lägg till användare till urvalsgrupp
@stop

@section('styles')
<link rel="stylesheet" href="{{ asset('/vendor/sumoselect-3.0.2/sumoselect.css') }}">
<style>
    .add-sample-member-form > label {
        float: none !important;
    }

    .SumoSelect label {
        float: none;
        margin-top: 0;
        margin-bottom: 0;
        color: #666;
    }

    .SumoSelect .optGroup {
        text-decoration: none !important;
    }

    .SumoSelect .optGroup label {
        color: #333 !important;
        padding-left: 15px;
        font-weight: bold;
    }

    .SlectBox {
        min-width: 400px;
    }

    .CaptionCont span {
        color: #CCC;
        font-style: italic;
    }

    .options .title span {
        display: none !important;
    }

    .options .title label {
        font-weight: bold;
        opacity: 1 !important; 
    }
</style>
@stop

@section('content')
    {{ Form::open(array('action' => array('SamplesController@postAddMember', $id), 'class' => 'info-form add-sample-member-form')) }}

        @if (!$errors->isEmpty())
        <p class="errors">{{ t($errors->first('members')) }}</p>
        @endif
        {{ Form::label('members', 'Användare') }}
        <select name="members[]" id="members" multiple="multiple">
            @foreach ($sections as $section => $students)
                <option class="title" value="-1" disabled="disabled">{{ $section }}</option>
                @foreach ($students as $user)
                    <option value="{{ $user->id }}">{{{ $user->first_name . " " . $user->last_name }}}</option>
                @endforeach
            @endforeach
        </select>
        <br>

        {{ Form::submit('Lägg till', array('class' => 'btn')) }} <a class="back-link" href="{{ url('/admin/samples/' . $id . '/members') }}">Avbryt</a>
    {{ Form::close() }}

    <script src="{{ asset('/vendor/sumoselect-3.0.2/jquery.sumoselect.min.js') }}"></script>
    <script>
    $("#members").SumoSelect({
        placeholder: "Välj",
        captionFormat: "{0} valda"
    });
</script>
@stop