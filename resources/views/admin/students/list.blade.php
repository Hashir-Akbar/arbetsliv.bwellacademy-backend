@extends('user-layout-without-panel')

@section('styles')
<link rel="stylesheet" href="{{ asset(version('/css/students.css')) }}">
<style>
    .hidden {
        display: none !important;
    }
</style>
@stop

@section('page-header')
    {{ __('students.students') }}
    @if ($showingSection)
        {{ $section->full_name() }}
    @endif
@stop

@section('content')
    <div class="students-search-container" style="float:right">
        <form id="students-search-form" action="{{ url('/admin/students') }}" method="GET"> 
            @if ($showingSection)
            <input type="hidden" name="section" value="{{ $section->id }}">
            @endif
            <input id="search" name="search" type="text" value="{{ $search }}">
            <input class="btn" type="submit" value="{{ __('general.search') }}">
        </form>
    </div>
    <div class="section-actions">
        <div>
            @if ($showingSection || !empty($search))
                <a href="{{ url('/admin/students') }}" class="btn">{{ __('students.show-all') }}</a>
            @else
                <a href="{{ url('/admin/sections') }}" class="btn">{{ __('students.select-section') }}</a>
            @endif
            @if ($user->canDo('create_students'))
                @if ($showingSection)
                    <a class="btn add-students-link" href="{{ url('/admin/sections/' . $section->id . '/students/add') }}">{{ __('students.new') }}</a>
                    <a class="btn import-students-link" href="{{ url('/admin/sections/' . $section->id . '/students/import') }}">{{ __('students.import') }}</a>
                    <a class="btn" href="{{ url('/admin/sections/' . $section->id . '/reginfo') }}">{{ __('students.codes') }}</a>
                @else
                    <div class="actions-info">
                        {{ __('students.select-section-info') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
    @if (count($students) > 0)
        <div class="responsive-table">
            <table class="table-students">
                <thead>
                    <tr>
                        <?php $urlPrefix = '/admin/students?' . ($showingSection ? 'section=' . $section->id . '&' : '') . ($search ? 'search=' . $search . '&' : ''); ?>
                        <th><a href="{{ url($urlPrefix . 'sort=first_name&type=' . ($sortType === 'asc' && $sort === 'first_name' ? 'desc' : 'asc')) }}">{{ __('general.first_name') }}</a></th>
                        <th><a href="{{ url($urlPrefix . 'sort=last_name&type=' . ($sortType === 'asc' && $sort === 'last_name' ? 'desc' : 'asc')) }}">{{ __('general.last_name') }}</a></th>
                        <th><a href="{{ url($urlPrefix . 'sort=sex&type=' . ($sortType === 'asc' && $sort === 'sex' ? 'desc' : 'asc')) }}">{{ __('general.sex') }}</a></th>
                        <th><a href="{{ url($urlPrefix . 'sort=birth_date&type=' . ($sortType === 'asc' && $sort === 'birth_date' ? 'desc' : 'asc')) }}">{{ __('general.birth_date') }}</a></th>
                        <th><a href="{{ url($urlPrefix . 'sort=is_test&type=' . ($sortType === 'asc' && $sort === 'is_test' ? 'desc' : 'asc')) }}">Test</a></th>
                        @if (!$showingSection)
                            <th>{{ __('students.section') }}</th>
                        @endif
                        <th>{{ __('general.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    @foreach ($students as $student)
                        <tr class="{{ $i % 2 == 0 ? 'odd' : 'even' }}">
                            <td>{{ $student->first_name }}</td>
                            <td>{{ $student->last_name }}</td>
                            <td>{{ $student->sexLabel() }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($student->birth_date)->toDateString() }}
                            </td>
                            <td>{{ $student->is_test ? 'Ja' : 'Nej' }}</td>
                            @if (!$showingSection)
                                <td>
                                    @if (!is_null($student->section))
                                    <a href="{{ url('/admin/students?section=' . $student->section->id) }}">{{ $student->section->full_name() }}</a>
                                    @endif
                                </td>
                            @endif
                            <td class="row-actions">
                                @if ($user->isSuperAdmin())
                                <a class="btn" href="{{ url('/user/' . $student->id . '/info') }}">{{ __('students.show') }}</a>
                                @endif
                                @if ($user->canDo('create_students'))
                                    <a class="btn" href="{{ url('/admin/students/' . $student->id . '/reginfo') }}">{{ __('students.code') }}</a> 
                                    <a class="btn" href="{{ url('/admin/students/' . $student->id . '/edit') }}">{{ __('general.edit') }}</a> 
                                    <a class="btn" href="{{ url('/admin/students/' . $student->id . '/delete') }}">{{ __('general.remove') }}</a>
                                @endif
                            </td>
                        </tr>
                        <?php $i += 1; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="no-students">
            @if ($user->isSuperAdmin() || $user->isAdmin() || $user->isNurse())
                <h3>{{ __('students.no-students') }}</h3>
            @else
                <h3>{{ __('students.no-students-accessible') }}</h3>
            @endif
        </div>
    @endif
    
    @if (count($paginationAppend) > 0)
        {{ $students->appends($paginationAppend)->links() }}
    @else
        {{ $students->links() }}
    @endif
@stop
