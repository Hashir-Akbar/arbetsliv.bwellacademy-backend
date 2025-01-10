@extends('user-layout-without-panel')

@section('page-header')
@if (config('fms.type') == 'work')
    Importera anställda till avdelning {{ $section->full_name() }}
@else
    Importera elever till klass {{ $section->full_name() }}
@endif
@stop

@section('content')
    {{ Form::open(array('action' => array("StudentController@postImport", $section->id), 'class' => 'import-students-form', "files" => true)) }}
    
    <h3>Följande krav måste uppfyllas</h3>
    <p>
        <ul>
            <li>Filformatet måste vara .xlsx</li>
            <li>Första raden räknas inte. Där kan du ha valfri text.</li>
            <li>
                Följande rader måste innehålla:<br>
                Förnamn, Efternamn, Emailadress, Födelsedatum, Kön
            </li>
        </ul>
        Ladda ner en exempelfil här:<br>
        <a class="download-link" href="{{ asset('/etc/FMSImportExempel.xlsx') }}">FMSImportExempel.xlsx</a> (Högerklicka och välj "Spara som...")
    </p>
    
    @if (!$errors->isEmpty())
    <p class="errors">{!! $errors->first('file') !!}</p>
    @endif
    {{ Form::label('file', 'Fil' . ' *') }}<br>
    {{ Form::file('file', array('required' => 'required')) }}<br>

    {{ Form::submit('Importera', array('class' => 'btn')) }}
    <a class="back-link" href="{{ url('/admin/students?section=' . $section->id) }}">Avbryt</a>

    {{ Form::close() }}
@stop