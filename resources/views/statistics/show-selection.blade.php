@extends('user-layout-without-panel')

@section('page-header')
Personer i urval
@stop

@section('styles')
<link rel="stylesheet" href="{{ asset('/css/students.css') }}">
@stop

@section('content')

<div class="responsive-table">
    <table class="table-students">
        <thead>
            <tr>
                <th>Förnamn</th>
                <th>Efternamn</th>
                <th>Kön</th>
                <th>Födelsedatum</th>
                <th>Klass</th>
                <th>Åtgärder</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($users as $student)
                <tr class="{{ $i % 2 == 0 ? 'odd' : 'even' }}">
                    <td class="first_name">{{ $student->first_name }}</td>
                    <td class="last_name">{{ $student->last_name }}</td>
                    <td class="sex">{{ $student->sex }}</td>
                    <td class="dob">
                        {{ \Carbon\Carbon::parse($student->birth_date)->toDateString() }}
                        @if (!is_null($student->birth_code))
                        {{ $student->birth_code }}
                        @endif
                    </td>
                    <td class="section">
                        @if (!is_null($student->section_id))
                            {{ $sectionLabels[$student->section_id] }}
                        @endif
                    </td>
                    <td class="row-actions">
                        <a href="{{ url('/user/' . $student->id . '/info') }}" class="btn" target="_blank">Visa profil</a>
                    </td>
                </tr>
                <?php $i += 1; ?>
            @endforeach
        </tbody>
    </table>
</div>

@stop