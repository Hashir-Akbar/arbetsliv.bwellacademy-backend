@extends('user-layout-without-panel')

@section('page-header')
{{ __('staff.staff') }}
@if ($showingUnit)
    {{ $unit->name }}
@endif
@stop

@section('styles')
<link rel="stylesheet" href="{{ asset(version('/css/students.css')) }}">
@stop

@section('content')
<div class="students-search-container" style="float:right">
    <form id="students-search-form" action="{{ url('/admin/staff') }}" method="GET"> 
        @if ($showingUnit)
        <input type="hidden" name="unit" value="{{ $unit->id }}">
        @endif
        <input id="search" name="search" type="text" value="{{ $search }}">
        <input class="btn" type="submit" value="{{ __('general.search') }}">
    </form>
</div>

<div class="section-actions">
    <div>
        @if ($currentUser->isSuperAdmin())
            @if ($showingUnit || !empty($search))
                <a href="{{ url('/admin/staff') }}" class="btn">{{ __('staff.show-all') }}</a>
            @else
                <a href="{{ url('/admin/units') }}" class="btn">{{ __('staff.select-unit') }}</a>
            @endif
        @else
            @if (!empty($search))
                <a href="{{ url('/admin/staff') }}" class="btn">{{ __('staff.show-all') }}</a>
            @endif
        @endif

        @if ($currentUser->isSuperAdmin() || $currentUser->isAdmin())
            @if ($showingUnit)
                <a href="{{ url('/admin/units/' . $unit->id . '/staff/new') }}" class="btn">{{ __('staff.new') }}</a>
            @else
                <div class="actions-info">
                    {{ __('staff.select-unit-info') }}
                </div>
            @endif
        @endif  
    </div>
</div>

<div class="responsive-table">
    <table class="table-students">
        <thead>
            <tr>
                <?php $urlPrefix = '/admin/staff?' . ($showingUnit ? 'unit=' . $unit->id . '&' : '') . ($search ? 'search=' . $search . '&' : ''); ?>
                <th><a href="{{ url($urlPrefix . 'sort=first_name&type=' . ($sortType === 'asc' && $sort === 'first_name' ? 'desc' : 'asc')) }}">{{ __('general.first_name') }}</a></th>
                <th><a href="{{ url($urlPrefix . 'sort=last_name&type=' . ($sortType === 'asc' && $sort === 'last_name' ? 'desc' : 'asc')) }}">{{ __('general.last_name') }}</a></th>
                <th>{{ __('general.email') }}</th>
                <th>{{ __('staff.twofactorauthentication-enabled') }}</th>
                <th>{{ __('staff.permissions') }}</th>
                @if (!$showingUnit)
                    @if ($currentUser->isSuperAdmin())
                    <th>{{ __('staff.unit') }}</th>
                    @endif
                @endif
                <th>{{ __('general.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($users as $user)
                <tr class="{{ $i % 2 == 0 ? 'odd' : 'even' }}">
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->hasEnabledTwoFactorAuthentication() ? __('general.yes') : __('general.no') }}</td>
                    <td>{{ $user->rolesLabel() }}</td>
                    @if (!$showingUnit)
                        @if ($currentUser->isSuperAdmin())
                        <td>
                            @if (!is_null($user->unit))
                            <a href="{{ url('/admin/staff?unit=' . $user->unit->id) }}">{{ $user->unit->name }}</a>
                            @endif
                        </td>
                        @endif
                    @endif
                    <td class="row-actions">
                        <a class="btn" href="{{ url('/admin/staff/' . $user->id . '/edit') }}">{{ __('general.edit') }}</a> 
                        <a class="btn" href="{{ url('/admin/staff/' . $user->id . '/delete') }}">{{ __('general.remove') }}</a>
                    </td>
                </tr>
                <?php $i += 1; ?>
            @endforeach
        </tbody>
    </table>
</div>
@if (count($paginationAppend) > 0)
    {{ $users->appends($paginationAppend)->links() }}
@else
    {{ $users->links() }}
@endif
@stop