@extends('user-layout-without-panel')

@section('title', __('profile.title'))

@section('page-header')
{{ __('profile.title') }}
@if ($mock)
    {{ __('profile.mock') }}
@else
    @if (isset($profile) && $profile->completed)
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

@section('styles')
<link rel="stylesheet" href="{{ asset('/vendor/qtip2-3.0.3/jquery.qtip.min.css') }}">
<link rel="stylesheet" href="{{ asset(version('/css/questionnaire.css')) }}">
@stop

@section('content')
<div class="pages">
    <ul class="page-menu">
        @foreach (App\Tile::all() as $tile)
        <?php
        if ($mock) {
            $url = url('/profile/mock/'. $tile['page']);
            $isActive = $tile['name'] == $page->name;
            $isLocked = false;
        } else {
            $url = url('/profile/' . $profile->id . '/page/' . $tile['page']);
            $isActive = $tile['name'] == $page->name;
            $isLocked = !$isActive && !$editable;
        }
        ?>
        <li>
            <a class="item {{ $isActive ? 'active' : '' }} {{ $isLocked ? 'locked' : '' }}" href="{{ $url }}"  title="{{ __($tile['label']) }}">
                <img src="{{ asset('images/icons/' . $tile['icon'] . '-active' . '.png') }}" alt="">
            </a>
        </li>
        @endforeach
        <li>
            @if ($mock)
            <a href="{{ url('/statement/mock/results') }}" class="item {{ $isLocked ? 'locked' : '' }}" title="{{ __('sidebar.results') }}">R</a>
            @else
            <a href="{{ url('/statement/' . $profile->id . '/results') }}" class="item {{ $isLocked ? 'locked' : '' }}" title="{{ __('sidebar.results') }}">R</a>
            @endif
        </li>
    </ul>
</div>

@if (!$mock && !$editable)
<div class="locked-profile">
    @if ($isUsersProfile)
        @if ($profile->completed)
            Du kan inte göra ändringar i den här profilen.
            <div>
                <a href="{{ url('profile/page/1') }}" class="next-btn">Börja en ny</a>
                @if ($profile->user->is_test)
                    <form method="POST" action="{{ action('ProfileController@postUnlock', $profile->id) }}">
                        @csrf
                        <input type="submit" class="next-btn" value="Lås upp">
                    </form>
                @endif
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
@elseif ($firstPage)
<div class="warning">
    <h4>{{ __('profile.skip') }}</h4>
    @if ($mock)
    <a href="{{ url('/profile/mock/' . $next) }}" class="next-btn">{{ __('profile.btn-next') }}</a>
    @else
    <a href="{{ url('/profile/' . $profile->id . '/page/' . $next) }}" class="next-btn">{{ __('profile.btn-next') }}</a>
    @endif
</div>
@endif

<div class="page">
    <h3 class="questionnaire-page-title">{{ $page->t_label() }}</h3>
    @if ($page->show_description)
    <div class="questionnaire-page-description">
        {!! $page->t_description() !!}
    </div>
    @endif

    <ul class="questions {{ $mock ? 'mock' : '' }}">
    @include('questionnaire._questions')
    </ul>

    @if (!$mock)
    <div id="autosave-info">
        {{ __('profile.autosave-info') }}
    </div>
    @endif

    <div class="button-container">
        @if (!$firstPage)
            @if ($mock)
            <a href="{{ url('/profile/mock/' . $prev) }}" class="prev-btn">{{ __('profile.btn-prev') }}</a>
            @else
            <a href="{{ url('/profile/' . $profile->id . '/page/' . $prev) }}" class="prev-btn">{{ __('profile.btn-prev') }}</a>
            @endif
        @endif

        @if (!$lastPage)
            @if ($mock)
            <a href="{{ url('/profile/mock/' . $next) }}" class="next-btn">{{ __('profile.btn-next') }}</a>
            @else
            <a href="{{ url('/profile/' . $profile->id . '/page/' . $next) }}" class="next-btn">{{ __('profile.btn-next') }}</a>
            @endif
        @else
            @if ($mock)
                <a href="{{ url('/statement/mock/results') }}" class="next-btn">{{ __('profile.btn-next') }}</a>
            @else
                <a href="{{ url('/statement/' . $profile->id . '/results') }}" class="next-btn">{{ __('profile.btn-result') }}</a>
            @endif
        @endif
    </div>

</div>

<div id="spinner" hidden>
    <img src="{{ url('/images/ajax-loader.gif') }}" alt="Laddar...">
</div>

<script>
    window.profile_id = <?= $profile->id; ?>;
    window.editable = <?= $editable ? 'true' : 'false' ?>;
    window.mock = <?= $mock ? 'true' : 'false' ?>;
</script>

<script src="{{ asset('/vendor/qtip2-3.0.3/jquery.qtip.min.js') }}"></script>
<script src="{{ asset(version('/js/questionnaire.js')) }}"></script>
<script src="{{ asset(version('/js/physical-tables.js')) }}"></script>
@stop