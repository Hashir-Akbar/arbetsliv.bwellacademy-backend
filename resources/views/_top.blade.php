<div class="top">
    <a href="{{ url('/') }}"><img class="logo" src="{{ asset('images/logo-bwell.png') }}" alt="Bwell"></a>
    @include('_nav-lang')
    @auth
    <ul class="nav navbar-nav nav-right" style="display: flex; align-items: center;">
        <li style="display: flex; align-items: center;">
            <span>{{ __('nav.logged_in_as') }}: {{ $user->full_name() }} ({{ $user->rolesLabel() }})</span>
        </li>
        <li style="display: flex; align-items: center;">
            <form method="POST" action="{{ route('logout') }}" style="display: flex; align-items: center;">
                <img src="{{ asset('images/profile-placeholder.png') }}" alt="User Icon" class="user-icon" style="width: 20px; height: 20px; margin-right: 5px; cursor: pointer;" onclick="handleUserIconClick()">
                @csrf
                <button type="submit" class="btn-logout">{{ __('nav.logout') }}</button>
            </form>
        </li>
    </ul>
    <div class="sidepanel" id="user" style="display: none; border-radius: 8px; margin-top: 10px; margin-right: 50px;">
        <div class="profile">
            <div class="profile-name">{{ $user->full_name() }}</div>
            <a class="sidebar-link edit-profile-link" href="{{ action('UserInfoController@getEdit') }}">{{ __('sidepanel.edit-user') }}</a>
        </div>
    </div>
    @endauth
</div>
<script>
    function handleUserIconClick() {
        const element = document.getElementById("user");
        if (element.style.display === "none" || element.style.display === "") {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    }
</script>