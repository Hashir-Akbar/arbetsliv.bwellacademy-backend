@extends('user-layout-without-panel')

@section('title')
Ny urvalsgrupp
@stop

@section('page-header')
Ny urvalsgrupp
@stop

@section('content')
<form method="POST" action="/admin/samples/new" class="info-form new-sample-form">
    @csrf
    @if ($errors->has('name'))
    <p class="errors">{{ $errors->first('name') }}</p>
    @endif
    <label for="name">Namn</label><br>
    <input type="text" name="name" value="{{ Request::old('name') }}" required><br>

    @if ($errors->has('unit'))
    <p class="errors">{{ $errors->first('unit') }}</p>
    @endif
    @if (isset($units))
        @if (config('fms.type') == 'work')
        <label for="unit">Företag</label><br>
        @else
        <label for="unit">Skola</label><br>
        @endif
        <select name="unit" id="unit">
            <option value="0">-- Välj --</option>
            @foreach ($units as $unit)
                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
            @endforeach
        </select><br>
    @else
        <input type="hidden" name="unit" value="{{ $unit->id }}">
    @endif

    <input type="submit" class="btn" value="Skapa">

    <a class="back-link" href="{{ url('/admin/samples') }}">Avbryt</a>
</form>
@stop