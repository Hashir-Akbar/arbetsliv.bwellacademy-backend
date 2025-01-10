@extends('user-layout-without-panel')

@section('page-header')
Förhandsgranskning
@stop

@section('styles')
<link rel="stylesheet" href="{{ asset('/css/students.css') }}">
<style>
    .hidden {
        display: none !important;
    }
</style>
@stop

@section('content')
    {{ Form::open(array('action' => array("StudentController@postCompleteImport", $section->id), 'class' => 'import-preview-form')) }}
    
    <p>
        @if (config('fms.type') == 'work')
        Så här kommer datan i filen läggas till i avdelning {{ $section->full_name() }}.
        @else
        Så här kommer datan i filen läggas till i klass {{ $section->full_name() }}.
        @endif
    </p>
    
    @if (count($errors) > 0)
    <p>
        Fel: 
    </p>
    @endif

    <div class="responsive-table">
        <table class="table-import-preview">
            <thead>
                <tr>
                    <th>Förnamn</th>
                    <th>Efternamn</th>
                    <th>Födelsedatum</th>
                    <th>Emailadress</th>
                    <th>Kön</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="first_name">
                        {{ $user['first_name'] }}
                    </td>
                    <td class="last_name">
                        {{ $user['last_name'] }}
                    </td>
                    <td class="birth_date">
                        {{ $user['birth_date'] }}
                    </td>
                    <td class="email">
                            {{ $user['email'] }}
                    </td>
                    <td class="sex">
                        @if ($user['sex']  == 'F')
                            Kvinna
                        @elseif ($user['sex']  == 'M')
                            Man
                        @else
                            Okänt
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p>
        {{ Form::submit('Importera', array('class' => 'btn import-btn')) }} 
        <a class="back-link" href="{{ url('/admin/sections/' . $section->id . '/students/import') }}">Avbryt</a>
    </p>

    {{ Form::close() }}
@stop