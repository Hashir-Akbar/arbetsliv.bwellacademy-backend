@extends('user-layout-without-panel')

@section('page-header')
Urvalsgrupper
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
<div class="section-actions">
    <a href="{{ url('/admin/samples/new') }}" class="btn new-btn">Ny urvalsgrupp</a>
</div>

<div class="responsive-table">
    <table class="table-samples">
        <thead>
            <tr>
                <th>Namn</th>
                @if ($user->isSuperAdmin())
                    <th>Enhet</th>
                @endif
                <th>Åtgärder</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($samples as $sample)
            <tr class="{{ $i % 2 == 0 ? 'odd' : 'even' }}">
                <td class="name">{{ $sample->label }}</td>
                @if ($user->isSuperAdmin())
                    @if (isset($sample->unit))
                        <td class="unit">{{ $sample->unit->name }}</td>
                    @else
                        <td></td>
                    @endif
                @endif
                <td class="row-actions">
                    <a class="edit-link" href="{{ url('/admin/samples/' . $sample->id . '/members') }}">Medlemmar</a>
                    <a class="edit-link" href="{{ url('/admin/samples/' . $sample->id . '/edit') }}">Ändra</a> 
                    <a class="remove-link" href="{{ url('/admin/samples/' . $sample->id . '/delete') }}">Ta bort</a>
                </td>
            </tr>
            <?php $i += 1; ?>
            @endforeach
        </tbody>
    </table>
</div>
@stop