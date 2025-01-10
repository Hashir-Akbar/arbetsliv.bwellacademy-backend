@extends('user-layout-without-panel')

@section('title')
Enkätsidor
@stop

@section('page-header')
Enkätsidor
@stop


@section('styles')
<link rel="stylesheet" href="{{ asset('/css/students.css') }}">
<style>
    .hidden {
        display: none;
    }
</style>
@stop


@section('content')
    <div class="responsive-table">
        <table class="list-questionnaire-pages">
            <thead>
                <tr>
                    <th>Titel</th>
                    <th>Åtgärder</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                <tr>
                    <td class="name">
                        <strong>
                            {{ $page->t_label() }}
                        </strong>
                        <br>
                        <span>Frågegrupper</span>
                        <ul style="margin-top: 0">
                            @foreach ($page->groups as $group)
                                <li>
                                    <a class="edit-group-link" href="{{ url('/admin/questionnaire/groups/' . $group->id . '/edit') }}">
                                        {{ $group->t_label() }}
                                    </a> 
                                    - 
                                    <a class="remove-group-link" href="{{ url('/admin/questionnaire/groups/' . $group->id . '/delete') }}">Ta bort</a>
                                </li>
                            @endforeach
                        </ul>
                        <a class="new-group-link btn" href="{{ url('/admin/questionnaire/groups/new/'. $page->id) }}">Ny frågegrupp</a>
                    </td>
                    <td class="row-actions">
                        <a class="edit-link" href="{{ url('/admin/questionnaire/pages/' . $page->id . '/edit') }}">Ändra</a> 
                        <a class="remove-link" href="{{ url('/admin/questionnaire/pages/' . $page->id . '/delete') }}">Ta bort</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ url('/admin/questionnaire/pages/new') }}" class="btn new-btn" style="position: relative; left: 40%">Ny sida</a>
@stop