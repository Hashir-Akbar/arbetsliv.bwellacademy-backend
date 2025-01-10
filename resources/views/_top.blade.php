<div class="top">
    <a href="{{ url('/') }}"><img class="logo" src="{{ asset('images/logo-bwell.png') }}" alt="Bwell"></a>
    @include('_nav-lang')
    @auth
    <ul class="nav navbar-nav nav-right">
        <li>
            <span>{{ __('nav.logged_in_as') }}: {{ $user->full_name() }} ({{ $user->rolesLabel() }})</span>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">{{ __('nav.logout') }}</button>
              </form>
        </li>
    </ul>
    @endauth
</div>