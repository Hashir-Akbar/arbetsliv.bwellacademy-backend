<?php

$data = [
    'sections' => 'Klasser',
    'new' => 'Ny klass',
    'show' => 'Visa',
    'show-all' => 'Visa alla',
    'select-unit' => 'Välj skola',
    'select-unit-info' => 'Välj en skola om du vill lägga till klasser.',
    'show-students' => 'Visa elever',
    'archived' => 'Arkiverad',

    'unit' => 'Skola',

    'school_year' => 'Årskurs',
    'program' => 'Program',
    'completed' => 'Avslutad',
];

if (config('fms.type') == 'work') {
    $data = array_merge($data, [
        'sections' => 'Avdelningar',
        'new' => 'Ny avdelning',
        'select-unit' => 'Välj företag',
        'select-unit-info' => 'Välj ett företag om du vill lägga till avdelningar.',
        'show-students' => 'Visa anställda',

        'unit' => 'Företag',
    ]);
}

return $data;
