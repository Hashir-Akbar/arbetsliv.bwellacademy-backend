@extends('user-layout-without-panel')

@section('title')
Ändra enkätsida
@stop

@section('page-header')
Ändra enkätsida
@stop

@section('content')
<form method="POST" action="{{ url("/admin/questionnaire/pages/{$id}/edit") }}" class="info-form edit-questionnaire-page-form">
    @csrf
    @if ($errors->has('label'))
    <p class="errors">{{ $errors->first('label') }}</p>
    @endif
    <label for="label">Namn *</label>
    <input type="text" name="label" value="{{ $label }}"><br>

    <label for="description">Beskrivning</label><br><br><br> 
    <textarea rows="5" cols="80" name="description">{{ $description }}</textarea><br>

    <input type="checkbox" id="show_description" name="show_description"{{ $show_description ? ' checked="checked"' : '' }}>
    <label for="show_description">Visa beskrivning</label><br>

    <input type="submit" value="Ändra" class="btn">
    <a class="back-link" href="{{ url('/admin/questionnaire/pages') }}">Avbryt</a>
</form>

    <div style="clear: both"></div>

@stop