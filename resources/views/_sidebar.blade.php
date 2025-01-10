<aside class="sidebar">
    <div class="sticky-wrapper">
        @include('_nav-sidebar', ['user' => Auth::user(), 'active' => $active ?? ''])
        @include('_address-info')
    </div>
</aside>