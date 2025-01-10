<div class="nav-sidebar">
    <ul class="nav-sidebar">
        @if ($user->isStudent())
            @include('_menu-student', array('active' => $active))
        @else
            @include('_menu-staff', array('active' => $active))
        @endif
    </ul>
    @include('_address-info')
</div>