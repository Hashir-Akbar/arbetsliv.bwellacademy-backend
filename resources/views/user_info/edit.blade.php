@extends('user-layout-without-panel')

@section('styles')
<link rel="stylesheet" href="{{ asset(version('/css/profile.css')) }}">
@stop

@section('page-header')
Redigera kontoinställningar
@stop

@section('content')
<form method="POST" action="{{ route('user-profile-information.update') }}" class="info-form form-edit-profile" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @if ($errors->any())
    <div class="errors">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
   
    <label for="email">Epostadress</label>
    <input type="email" name="email" id="email" value="{{ old('email') ?? $user->email }}" placeholder="Email" class="form-control"><br>

    <a href="{{ url('/user/info/password') }}">Ändra lösenord</a><br>
    
    <input type="submit" value="Spara" class="btn">
    <a class="back-link" href="{{ url('/') }}">Avbryt</a>
</form>

<br clear="all">

@if (!auth()->user()->isStudent())
    @if (session('status') == 'two-factor-authentication-enabled')
        <form method="POST" action="{{ url('user/confirmed-two-factor-authentication') }}" class="info-form form-edit-profile">
            @csrf

            <p>För att slutföra aktiveringen av tvåfaktorsautentisering, skanna QR-koden med telefonens autentiseringsapplikation och ange den genererade koden.</p>
            <p>{!! auth()->user()->twoFactorQrCodeSvg() !!}</p>

            <input type="text" class="form-control" name="code" required>

            <input type="submit" class="btn" value="Fortsätt">
        </form>
    @else
        <form method="POST" action="{{ url('user/two-factor-authentication') }}" class="info-form form-edit-profile">
            @csrf

            @if (auth()->user()->two_factor_secret && auth()->user()->two_factor_confirmed_at)
                @method('DELETE')
                <p>Tvåfaktorsautentisering är aktiverad.</p>
                <input type="submit" value="Deaktivera">
            @else
                <p>Tvåfaktorsautentisering är inte aktiverad.</p>
                <input type="submit" value="Aktivera">
            @endif
        </form>
    @endif
@endif

@stop
