@extends('user-layout-with-panel')

@section('styles')
<link rel="stylesheet" href="{{ asset(version('/css/profile.css')) }}">
<style>
    .info-block .profiles-list,
    .info-block .physicals-list {
        line-height: normal;
    }

    .info-block .profiles-list li,
    .info-block .physicals-list li {
        float: none;
    }

    .info-block {
        display: block;
        float: left;
        margin-right: 25px;
    }

    .info-block p {
        line-height: 20px;
        margin: 0;
    }
</style>
@stop

@section('page-header')
{{ $user->full_name() }}
@stop

@section('content')

<div class="info-block">
    <h3>Information</h3>
    <p>
        <strong>Epostadress</strong>: {{ empty($user->email) ? 'Ingen epost angiven' : $user->email }}<br>
        @if (isset($user->birth_date))
            <strong>Födelsedatum</strong>: {{ $user->birth_date->toDateString() }}<br>
        @endif
        @if (isset($user->section))
            @if (config('fms.type') == 'work')
                <strong>Företag</strong>: {{ $user->section->unit->name }}<br>
                <strong>Avdelning</strong>: {{ $user->section->full_name() }}
            @else
                <strong>Skola</strong>: {{ $user->section->unit->name }}<br>
                <strong>Klass</strong>: {{ $user->section->full_name() }}
            @endif
        @endif
    </p>
</div>

<div class="info-block">
    <h3>Livsstilsplaner</h3>
    @if ($canSee)
        <?php $count = $user->profiles()->count(); ?>
        @if ($count > 0)
        <ul class="profiles-list">
            @foreach ($user->profiles as $profile)
                <li>
                    @if ($profile->in_progress)
                    <span class="profile-count profile-in-progress">{{ $count-- }}</span>
                    @elseif ($profile->completed)
                    <span class="profile-count">{{ $count-- }}</span>
                    @else
                    <span class="profile-count profile-almost-done">{{ $count-- }}</span>
                    @endif
                    <span class="health_profile-date">{{ $profile->date }}</span>
                    @if ($canSeeEverything)
                        <a href="{{ url('/profile/' . $profile->id . '/page/1') }}" class="show-profile-link">Livsstilsanalys</a>
                    @endif
                    @if ($canSee)
                        <a href="{{ url('/statement/' . $profile->id . '/plan') }}" class="show-profile-link">Livsstilsplan</a>
                    @endif
                </li>
            @endforeach
        </ul>
        @else
            <h4>Den här användaren har inte gjort några livsstilsplaner.</h4>
        @endif
    @else
        <h4 class="cannot-see">Du har inte tillåtelse att se den här användarens livsstilsplaner.</h4>
    @endif
</div>

<div style="clear:both"></div>
@stop

