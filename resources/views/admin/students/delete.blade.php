@extends('user-layout-without-panel')

@section('page-header')
@if (config('fms.type') == 'work')
    Ta bort anställd
@else
    Ta bort elev
@endif
@stop

@section('content')
<form method="POST" action="{{ url("admin/students/{$id}/delete") }}" class="info-form delete-student-form">
    @csrf
    <p>
        Är du säker på att du vill ta bort <em>{{ $user->full_name() }}</em>?
    </p>
    <input type="submit" class="btn" value="Ta bort">
    <a class="back-link" href="{{ url('/admin/students?section=' . $user->section_id) }}">Avbryt</a>
</form>
@stop