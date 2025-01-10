<div class="profile-profiles">
    <h3 class="menu-header">{{ __('sidepanel.latest-profiles') }}</h3>
    <ul class="profiles-list">
        @if ($user->hasProfiles())
            <?php $count = $user->profiles()->count(); ?>
            @foreach ($user->latestProfiles() as $profile)
                <li>
                    <a class="sidebar-link view-profile" href="{{ url('/statement/' . $profile->id . '/plan') }}">
                        @if ($profile->in_progress)
                        <span class="profile-count profile-in-progress">{{ $count-- }}</span>
                        @elseif ($profile->completed)
                        <span class="profile-count">{{ $count-- }}</span>
                        @else
                        <span class="profile-count profile-almost-done">{{ $count-- }}</span>
                        @endif
                        <span class="health_profile-date">{{ $profile->date }}</span>
                    </a>
                </li>
            @endforeach
            @if ($user->profiles()->count() > 5)
                <li><a class="sidebar-link view-more-profiles" href="{{ url('/profiles') }}">{{ __('sidepanel.all-profiles') }}</a></li>
            @endif
        @else
            <li>{{ __('sidepanel.no-profiles') }}</li>
        @endif
    </ul>
    @if ($user->hasProfiles())
        <a class="sidebar-link view-statement" href="{{ url('/statement/' . $user->latestProfile()->id . '/plan') }}">{{ __('sidepanel.latest-profile') }}</a>
    @endif
</div>

<script>
    $(document).ready(function() {
        $('.sidepanel #student-list, #all-students-list').change(function() {
            var $this = $(this);
            var value = parseInt($this.val());
            if (value === -1)
                return;
            var url = fms_url + "/user/" + value + "/info";
            window.location.assign(url);
        });

        $('.close-revoke').click(function(e) {
            e.preventDefault();
            $.magnificPopup.close();
        });
    });
</script>
