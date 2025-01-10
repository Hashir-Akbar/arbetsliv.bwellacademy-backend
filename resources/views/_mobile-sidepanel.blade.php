<div>
    <div class="language-control">
        @if (config('fms.type') == 'school')
        <a class="{{ App::isLocale('sv') ? 'active-lang' : '' }}" href="{{ url('/lang/sv') }}"><img src="/images/se.png" alt="Svenska"> SV</a>
        <a class="{{ App::isLocale('en') ? 'active-lang' : '' }}" href="{{ url('/lang/en') }}"><img src="/images/gb.png" alt="English"> EN</a>
        @endif
    </div>

    <div class="logout">
        <a class="btn" href="{{ url('/logout') }}">{{ __('nav.logout') }}</a>
    </div>
</div>
<div class="profile">
    <div class="profile-name">{{ $user->full_name() }}</div>
    <a class="sidebar-link edit-profile-link" href="{{ action('UserInfoController@getEdit') }}">{{ __('sidepanel.edit-user') }}</a>
</div>
