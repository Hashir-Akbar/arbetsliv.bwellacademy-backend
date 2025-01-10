@extends('user-layout-without-panel')

@section('title')
Urvalsgruppsmedlemmar
@stop

@section('page-header')
Urvalsgruppsmedlemmar
@stop

@section('content')

<h3 class="sample-name">{{ $sample->label }}</h3>
<ul class="sample-members">
@foreach ($sample->members as $user)
    <li class="member">{{ $user->full_name() }} <a class="remove-student-link remove" href="{{ url('/admin/samples/' . $sample->id . '/members/remove/' . $user->id) }}">X</a></li>
@endforeach
</ul>
<a class="add-students-link" href="{{ url('/admin/samples/' . $sample->id . '/members/add') }}">Lägg till användare</a>
<br>
<br>
<a class="back-link" href="{{ url('/admin/samples') }}">Tillbaka</a>

@stop