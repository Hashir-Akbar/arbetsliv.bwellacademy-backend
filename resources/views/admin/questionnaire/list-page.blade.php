@extends('user-layout-without-panel')

@section('title')
Enkätsidor
@stop

@section('page-header')
Enkätsidor
@stop

@section('content')
    <div class="responsive-table">
        <table>
            <thead>
                <tr>
                    <th>Titel</th>
                    <th>Åtgärder</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                <tr>
                    <td>
                        @if (Lang::has($page->label))
                            {{ trans($page->label) }}
                        @else
                            {{ $newPage }}
                        @endif
                        <br>
                        @if ($page->hasGroups())
                        <ul>
                            @foreach ($page->groups as $group)
                                <li>
                                    <span>
                                        @if (Lang::has($group->label))
                                            {{ trans($group->label) }}
                                        @else
                                            {{ $newGroup }}
                                        @endif
                                    </span>    
                                    Ändra - Ta bort
                                </li>
                            @endforeach
                        </ul>
                        @endif
                        <a href="{{ url('/admin/questionnaire/groups/new/' . $page->id) }}">Ny frågegrupp</a>
                    </td>
                    <td>
                        <a href="{{ url('/admin/questionnaire/pages/' . $page->id . '/edit') }}">Ändra</a> - Ta bort
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ url('/admin/questionnaire/pages/new') }}">Ny sida</a>
@stop