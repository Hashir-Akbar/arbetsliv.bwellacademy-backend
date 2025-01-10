<ul class="nav-sidebar">
@if (!is_null($user))
    @if ($user->isStudent())
        @include('_menu-student', array('active' => $active))
    @else
        @include('_menu-staff', array('active' => $active))
    @endif
@endif
</ul>