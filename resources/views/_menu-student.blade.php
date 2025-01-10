{!! $active == "panel" ? '<li class="active">' : '<li>' !!}<a href="{{ url('/') }}">{{ __('nav.start') }}</a></li>
@if ($user->isStudent())
    @if (isset($profile))
        {!! ($active == "questionnaire" || $active == "statement-results") ? '<li class="active">' : '<li>' !!}<a href="{{ url('/profile/' . $profile->id . '/page/1') }}">{{ __('nav.analysis') }}</a></li>
    @else
        {!! ($active == "questionnaire" || $active == "statement-results") ? '<li class="active">' : '<li>' !!}<a href="{{ url('/profile/page/1') }}">{{ __('nav.analysis') }}</a></li>
    @endif
    @foreach (App\Tile::all() as $tile)
        {!! isset($activePage) && $activePage == $tile['name'] ? '<li class="submenu active-page ' . $tile['name'] . '">' : '<li class="submenu ' . $tile['name'] . '">' !!}
        @if (isset($profile))
            <a href="{{ url('/profile/' . $profile->id . '/page/' . $tile['page']) }}">
        @else
            <a href="{{ url('/profile/page/' . $tile['page']) }}">
        @endif
            <span class="icon"><img src="{{ asset('images/icons/' . $tile['icon'] . '.png') }}" alt="{{ t($tile['label']) }}"></span>
            {{ t($tile['label']) }}
        </a>
    </li>
    @endforeach
    @if ($user->hasProfiles())
        @if (isset($profile))
        {!! $active == "statement-results" ? '<li class="submenu active-page">' : '<li class="submenu">' !!}<a href="{{ url('/statement/' . $profile->id . '/results') }}"><span class="no-icon"></span>{{ __('nav.results') }}</a></li>
        {!! $active == "statement-goals" ? '<li class="active">' : '<li>' !!}<a href="{{ url('/statement/' . $profile->id . '/goals') }}">{{ __('nav.goals') }}</a></li>
        {!! $active == "statement-plan" ? '<li class="active">' : '<li>' !!}<a href="{{ url('/statement/' . $profile->id . '/plan') }}">{{ __('nav.plan') }}</a></li>
        {!! $active == "statement-compare" ? '<li class="active">' : '<li>' !!}<a href="{{ url('/statement/' . $profile->id . '/compare') }}">{{ __('nav.compare') }}</a></li>
        @else
        {!! $active == "statement-results" ? '<li class="submenu active-page">' : '<li class="submenu">' !!}<a href="{{ url('/statement/results') }}"><span class="icon"></span>{{ __('nav.results') }}</a></li>
        {!! $active == "statement-goals" ? '<li class="active">' : '<li>' !!}<a href="{{ url('/statement/goals') }}">{{ __('nav.goals') }}</a></li>
        {!! $active == "statement-plan" ? '<li class="active">' : '<li>' !!}<a href="{{ url('/statement/plan') }}">{{ __('nav.plan') }}</a></li>
        {!! $active == "statement-compare" ? '<li class="active">' : '<li>' !!}<a href="{{ url('/statement/compare') }}">{{ __('nav.compare') }}</a></li>
        @endif
    @endif
@endif
