@extends('user-layout-without-panel')

@section('styles')
<link rel="stylesheet" href="{{ asset('/css/students.css') }}">
<style>
    .hidden {
        display: none !important;
    }
</style>
@stop

@section('page-header')
{{ __('sections.sections') }}
@if ($showingUnit)
    {{ $unit->name }}
@endif
@stop

@section('content')
<div class="students-search-container" style="float:right; display: flex;">
    <select name="unit" id="unit-select" style="margin-right: 10px;">
        <option value="" {{ is_null(optional($section ?? null)->unit_id) ? 'selected' : '' }}>
            Select Company
        </option>
        @foreach ($units as $iterUnit)
            <option value="{{ $iterUnit->id }}" {{ $iterUnit->id == optional($unit ?? null)->id ? 'selected' : '' }}>
                {{ $iterUnit->name }}
            </option>
        @endforeach
    </select>
    <script>
            document.getElementById('unit-select').addEventListener('change', function() {
                var unitId = this.value;
                var sectionId = document.getElementById('unit-select').value;
                window.location.href = '/admin/sections?unit=' + unitId;
            });
    </script>
    <form id="students-search-form" action="{{ url('/admin/sections') }}" method="GET" style="display: flex; align-items: center;">
        <label for="show-archived" style="display: flex; align-items: center; margin-right: 20px;">
            <input type="checkbox" id="show-archived" value="1" name="show-archived" {!! ($showArchived ? 'checked' : '') !!}>
            <span style="margin-left: 5px;">Visa arkiverade</span>
        </label>
        @if ($showingUnit)
        <input type="hidden" name="unit" value="{{ $unit->id }}">
        @endif
        <input id="search" name="search" type="text" value="{{ $search }}">
        <input class="btn" type="submit" value="{{ __('general.search') }}">
    </form>
</div>

<div class="section-actions">
    <div>
        @if ($user->isSuperAdmin())
            @if ($showingUnit || !empty($search))
                <a href="{{ url('/admin/sections') }}" class="btn" style="margin-right: 10px;">{{ __('sections.show-all') }}</a>
            @else
                <!-- <a href="{{ url('/admin/units') }}" class="btn">{{ __('sections.select-unit') }}</a> -->
            @endif
        @else
            @if (!empty($search))
                <a href="{{ url('/admin/sections') }}" class="btn" style="margin-right: 10px;">{{ __('sections.show-all') }}</a>
            @endif
        @endif

        @if ($user->isSuperAdmin() || $user->isAdmin())
            @if ($showingUnit)
                <a href="{{ url('/admin/units/' . $unit->id . '/sections/new') }}" class="btn" style="margin-right: 10px;">{{ __('sections.new') }}</a>
            @else
                <div class="actions-info">
                    {{ __('sections.select-unit-info') }}
                </div>
            @endif
        @endif
    </div>
</div>

<div class="responsive-table">
    <table class="table-students">
        <thead>
            <tr>
                <?php $urlPrefix = '/admin/sections?' . ($showingUnit ? 'unit=' . $unit->id . '&' : '') . ($search ? 'search=' . $search . '&' : ''); ?>
                <th><a href="{{ url($urlPrefix . 'sort=name&type=' . ($sortType === 'asc' && $sort === 'name' ? 'desc' : 'asc')) }}">{{ __('general.name') }}</a></th>
                @if (config('fms.type') == 'school')
                    <th>{{ __('sections.program') }}</th>
                    <th><a href="{{ url($urlPrefix . 'sort=school_year&type=' . ($sortType === 'asc' && $sort === 'school_year' ? 'desc' : 'asc')) }}">{{ __('sections.school_year') }}</a></th>
                    <th><a href="{{ url($urlPrefix . 'sort=completed&type=' . ($sortType === 'asc' && $sort === 'completed' ? 'desc' : 'asc')) }}">{{ __('sections.completed') }}</a></th>
                @endif
                @if (!$showingUnit)
                    <th>{{ __('sections.unit') }}</th>
                @endif
                @if ($showArchived)
                    <th>{{ __('sections.archived') }}</th>
                @endif
                <th>{{ __('general.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($sections as $section)
                <tr class="{{ $i % 2 == 0 ? 'odd' : 'even' }}">
                    <td>{{ $section->name }}</td>
                    @if (config('fms.type') == 'school')
                        @if (!is_null($section->program))
                            <td>{{ $section->program->label }}</td>
                        @else
                            <td></td>
                        @endif
                        <td>{{ $section->school_year }}</td>
                        <td>{{ $section->completed ? 'Ja' : 'Nej' }}</td>
                    @endif
                    @if (!$showingUnit)
                        <td>
                            @if (!is_null($section->unit))
                            <a href="{{ url('/admin/sections?unit=' . $section->unit->id) }}">{{ $section->unit->name }}</a>
                            @endif
                        </td>
                    @endif
                    @if ($showArchived)
                        <td>{{ !is_null($section->archived_at) ? 'Ja' : 'Nej' }}</td>
                    @endif
                    <td class="row-actions">
                        <a href="{{ url('/admin/students?section=' . $section->id) }}" class="btn">{{ __('sections.show-students') }}</a>
                        @if ($user->isSuperAdmin() || $user->isAdmin())
                            <a class="btn btn-outline" href="{{ url('/admin/sections/' . $section->id . '/edit') }}">{{ __('general.edit') }}</a>
                            <a class="btn btn-danger btn-outline" href="{{ url('/admin/sections/' . $section->id . '/delete') }}">{{ __('general.remove') }}</a>
                            <a class="btn btn-danger btn-outline" href="{{ url('/admin/sections/' . $section->id . '/archive') }}">{{ __('general.archive') }}</a>
                            <a class="btn btn-danger btn-outline" href="{{ url('/admin/sections/' . $section->id . '/qr') }}">{{ __('general.qr') }}</a>
                        @endif
                    </td>
                </tr>
                <?php $i += 1; ?>
            @endforeach
        </tbody>
    </table>
</div>

@if (count($paginationAppend) > 0)
{{ $sections->appends($paginationAppend)->links() }}
@else
{{ $sections->links() }}
@endif
@stop