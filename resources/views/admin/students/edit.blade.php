@extends('user-layout-without-panel')

@section('page-header')
@if (config('fms.type') == 'work')
    Ändra anställd
@else
    Ändra elev
@endif
@stop

@section('content')
<form method="POST" action="{{ url("admin/students/{$user->id}/edit") }}" class="info-form edit-student-form">
    @csrf

    <input type="checkbox" name="is_test" {{ $user->is_test ? 'checked="checked"' : '' }}>
    <label for="is_test">Testanvändare</label><br>

    @if ($errors->has('first_name'))
    <span class="errors">{{ $errors->first('first_name') }}</span>
    @endif
    <label for="first_name">Förnamn *</label>
    <input type="text" name="first_name" value="{{ $user->first_name }}"><br>

    @if ($errors->has('last_name'))
    <span>{{ $errors->first('last_name') }}</span>
    @endif
    <label for="last_name">Efternamn *</label>
    <input type="text" name="last_name" value="{{ $user->last_name }}"><br>

    @if ($errors->has('email'))
    <span>{{ $errors->first('email') }}</span>
    @endif
    <label for="email">Emailadress</label>
    <input type="text" name="email" value="{{ $user->email }}"><br>

    @if ($errors->has('sex'))
    <span>{{ $errors->first('sex') }}</span>
    @endif
    <label for="sex">Kön *</label>
    <select name="sex" id="sex">
        @if ($user->sex == 'M')
        <option value="U">Okänt</option>
        <option value="M" selected="selected">Man</option>
        <option value="F">Kvinna</option>
        @elseif ($user->sex == 'F')
        <option value="U">Okänt</option>
        <option value="M">Man</option>
        <option value="F" selected="selected">Kvinna</option>
        @else
        <option value="U" selected="selected">Okänt</option>
        <option value="M">Man</option>
        <option value="F">Kvinna</option>
        @endif
    </select><br>

    @if ($errors->has('birth_date'))
    <span>{{ $errors->first('birth_date') }}</span>
    @endif
    <label for="birth_date">Födelsedatum *</label>
    @php
    if (!is_null($user->birth_date)) {
        $birth_date = $user->birth_date->toDateString('Y-m-d');
    } else {
        $birth_date = '';
    }
    @endphp
    <input type="text" class="birth_date" id="birth_date" name="birth_date" value="{{ $birth_date }}" placeholder="åååå-mm-dd">
    
    <label for="class">{{ __('students.section') }} *</label><br>
    <select name="section" id="class">
        @if (!is_null($unit))
        @foreach ($unit->sections->sortBy('name') as $section)
            @if ($section->id == $user->section_id)
            <option value="{{ $section->id }}" selected="selected">{{ $section->full_name() }}</option>
            @else
            <option value="{{ $section->id }}">{{ $section->full_name() }}</option>
            @endif
        @endforeach
        @endif
    </select>

    <input type="submit" class="btn" value="Spara">
    <a class="back-link" href="{{ url('/admin/students?section=' . $user->section_id) }}">Avbryt</a>

</form>
@stop