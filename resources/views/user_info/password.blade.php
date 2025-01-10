@extends('user-layout-without-panel')

@section('styles')
<link rel="stylesheet" href="{{ asset(version('/css/profile.css')) }}">
@stop

@section('page-header')
Ändra lösenord
@stop

@section('content')
<form method="POST" action="{{ route('user-password.update') }}" class="info-form form-edit-profile" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @if (session('status') === 'password-updated')
    <p class="status">
        Lösenordet har uppdaterats.
    </p>
    @endif

    @if ($errors->updatePassword->any())
    <div class="errors">
        <ul>
            @foreach ($errors->updatePassword->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <label for="password">Ändra lösenord</label>
    <input type="password" name="current_password" id="current_password" placeholder="Nuvarande lösenord" class="form-control" required><br>
    <input type="password" name="password" id="password" placeholder="Lösenord" class="form-control" required><br>
    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Bekräfta lösenord" class="form-control" required><br>

    <input type="submit" value="Spara" class="btn">
    <a class="back-link" href="{{ url('/user/info/edit') }}">Avbryt</a>
</form>
@stop
