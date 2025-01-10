<div class="sidepanel">
    <div class="profile">
        <div class="profile-name">{{ $user->full_name() }}</div>
        <a class="sidebar-link edit-profile-link" href="{{ action('UserInfoController@getEdit') }}">{{ __('sidepanel.edit-user') }}</a>
    </div>
    @if ($user->isStudent())
        @include('_sidepanel-student', ['user' => Auth::user()])
    @endif
</div>
