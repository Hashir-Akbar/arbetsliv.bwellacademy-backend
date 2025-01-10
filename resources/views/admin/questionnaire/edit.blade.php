@extends('user-layout-without-panel')

@section('title')
Ändra enkätsida
@stop

@section('page-header')
Ändra enkätsida
@stop

@section('content')
<form method="POST" action="{{-- url("/admin/questionnaire/pages/{$id}/edit") --}}" class="info-form">
    <label for="label">Namn *</label>
    <span>{{ $errors->first('label') }}</span><br>
    <input type="text" name="label" value="{{ $label }}"><br>

    <label for="description">Beskrivning</label><br>
    <textarea name="description">{{ $description }}</textarea>

    <input type="submit" value="Ändra">
    <a href="{{ url('/admin/questionnaire/pages') }}" class="back-link">Avbryt</a>
</form>
@stop