@extends('user-layout-without-panel')

@section('styles')
<link rel="stylesheet" href="{{ asset(version('/css/statement.css')) }}">
@stop

@section('page-header')
@yield('page-title')
@if ($mock)
    {{ __('profile.mock') }}
@else
    @if ($profile->completed)
        {{ $profile->date }}
    @endif
    @if (!$isUsersProfile)
    <br>
    <a style="text-transform:none;font-size:0.65em" href="{{ url('/user/' . $profile->user->id . '/info') }}">
        {{ $profile->user->full_name() }} ({{ $profile->user->birth_date->toDateString() }}) {{ $profile->user->section->unit->name }} {{ $profile->user->section->full_name() }}
    </a>
    @endif
@endif
@stop

@section('content')
    @if (isset($canSeeEverything) && $canSeeEverything)
    <div class="pages">
        <ul class="page-menu">
            @foreach (App\Tile::all() as $tile)
            <?php
            if ($mock) {
                $url = url('/profile/mock/'. $tile['page']);
                $isLocked = false;
            } else {
                $url = url('/profile/' . $profile->id . '/page/' . $tile['page']);
                $isLocked = !$profile->in_progress;
            }
            ?>
            <li>
                <a class="item {{ $isLocked ? 'locked' : '' }}" href="{{ $url }}"  title="{{ __($tile['label']) }}">
                    <img src="{{ asset('images/icons/' . $tile['icon'] . '-active' . '.png') }}" alt="">
                </a>
            </li>
            @endforeach
            <li>
                @if ($mock)
                <a href="{{ url('/statement/mock/results') }}" class="item active" title="{{ __('sidebar.results') }}">R</a>
                @else
                <a href="{{ url('/statement/' . $profile->id . '/results') }}" class="item active" title="{{ __('sidebar.results') }}">R</a>
                @endif
            </li>
        </ul>
    </div>
    @endif
    @if (!$mock && !$editable)
    <div class="locked-profile">
        @if ($isUsersProfile)
            @if ($profile->completed)
                Du kan inte göra ändringar i den här profilen.
                <div>
                    <a href="{{ url('profile/page/1') }}" class="next-btn">Börja en ny</a>
                    <form method="POST" action="{{ action('ProfileController@postUnlock', $profile->id) }}">
                        @csrf
                        <input type="submit" class="next-btn" value="Lås upp">
                    </form>
                </div>
            @else
                Du kan inte göra ändringar i den här livsstilsanalysen.
                <div>
                    <a href="{{ url('/statement/' . $profile->id . '/satisfied') }}" class="next-btn">Gå till livsstilsplanen</a>
                    @if ($profile->user->is_test)
                        <form method="POST" action="{{ action('ProfileController@postUnlock', $profile->id) }}">
                            @csrf
                            <input type="submit" class="next-btn" value="Lås upp">
                        </form>
                    @endif
                </div>
            @endif
        @else
            Du kan inte göra ändringar i den här profilen.
            @if ($user->isSuperAdmin() && !$profile->in_progress)
            <div>
                <form method="POST" action="{{ action('ProfileController@postUnlock', $profile->id) }}">
                    @csrf
                    <input type="submit" class="next-btn" value="Lås upp">
                </form>
            </div>
            @endif
        @endif
    </div>
    @endif
    <div class="page">
        @yield('tab-contents')
    </div>
@stop