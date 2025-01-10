@extends('user-layout-without-panel')

@section('page-header')
{{ __('units.units') }}
@stop

@section('styles')
<link rel="stylesheet" href="{{ asset('/css/students.css') }}">
@stop

@section('content')
<div class="students-search-container" style="float:right">
    <form id="students-search-form" action="{{ url('/admin/units') }}" method="GET">
        <input id="search" name="search" type="text" value="{{ $search }}">
        <input class="btn" type="submit" value="{{ __('general.search') }}">
    </form>
</div>

<div class="section-actions">
    <div>
        @if (!empty($search))
            <a href="{{ url('/admin/units') }}" class="btn">{{ __('units.show-all') }}</a>
        @endif
        @if ($user->isSuperAdmin())
            <a href="{{ url('/admin/units/new') }}" class="btn">{{ __('units.new') }}</a>
        @endif
    </div>
</div>

<div class="responsive-table">
    <table class="table-students">
        <thead>
            <tr>
                <?php $urlPrefix = '/admin/units?' . ($search ? 'search=' . $search . '&' : ''); ?>
                <th><a href="{{ url($urlPrefix . 'sort=name&type=' . ($sortType === 'asc' && $sort === 'name' ? 'desc' : 'asc')) }}">{{ __('general.name') }}</a></th>
                <th>{{ __('general.country') }}</th>
                <th>{{ __('general.county') }}</th>
                @if (config('fms.type') == 'school')
                    <th>{{ __('units.school-type') }}</th>
                @endif
                @if (config('fms.type') == 'work')
                    <th>{{ __('units.business-category') }}</th>
                @endif
                @if ($user->isSuperAdmin())
                    <th>{{ __('general.email') }}</th>
                    <th>{{ __('general.phone') }}</th>
                @endif
                <th>{{ __('general.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($units as $unit)
                <tr class="{{ $i % 2 == 0 ? 'odd' : 'even' }}">
                    <td>{{ $unit->name }}</td>
                    <td>{{ $unit->countryLabel() }}</td>
                    <td>{{ $unit->countyLabel() }}</td>
                    @if (config('fms.type') == 'school')
                        @if ($unit->school_type === 'unit.none')
                        <td></td>
                        @else
                        <td>{{ t($unit->school_type) }}</td>
                        @endif
                    @endif
                    @if (config('fms.type') == 'work')
                        <td>{{ $unit->business_category?->name ?? '' }}</td>
                    @endif
                    @if ($user->isSuperAdmin())
                        <td>{{ $unit->email }}</td>
                        <td>{{ $unit->phone }}</td>
                    @endif
                    <td class="row-actions">
                        <a class="btn" href="{{ url('/admin/staff?unit=' . $unit->id) }}">{{ __('units.show-staff') }}</a>
                        <a class="btn" href="{{ url('/admin/sections?unit=' . $unit->id) }}">{{ __('units.show-sections') }}</a>
                        @if ($user->isSuperAdmin())
                            <a class="btn" href="{{ url('/admin/units/' . $unit->id . '/edit') }}">{{ __('general.edit') }}</a>
                            <a class="btn" href="{{ url('/admin/units/' . $unit->id . '/delete') }}">{{ __('general.remove') }}</a>
                        @endif
                    </td>
                </tr>
                <?php $i += 1; ?>
            @endforeach
        </tbody>
    </table>
</div>

@if (count($paginationAppend) > 0)
{{ $units->appends($paginationAppend)->links() }}
@else
{{ $units->links() }}
@endif
@stop