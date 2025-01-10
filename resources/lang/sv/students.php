<?php

$data = [
    'students' => 'Elever',
    'new' => 'Lägg till elever',
    'import' => 'Importera elever',
    'show' => 'Visa',
    'show-multiple' => 'Visa elever',
    'show-all' => 'Visa alla',
    'select-section' => 'Välj klass',
    'select-section-info' => 'Välj en klass om du vill lägga till elever.',

    'unit' => 'Skola',
    'section' => 'Klass',

    'code' => 'Reg.kod',
    'codes' => 'Reg.koder',

    'no-students' => 'Hittade inga elever.',
    'no-students-accessible' => 'Hittade inga elever som du har åtkomst till.',
];

if (config('fms.type') == 'work') {
    $data = array_merge($data, [
        'students' => 'Anställda',
        'new' => 'Lägg till anställda',
        'import' => 'Importera anställda',
        'show' => 'Visa',
        'show-multiple' => 'Visa anställda',
        'show-all' => 'Visa alla',
        'select-section' => 'Välj avdelning',
        'select-section-info' => 'Välj en avdelning om du vill lägga till anställda.',
        'unit' => 'Företag',
        'section' => 'Avdelning',
        'no-students' => 'Hittade inga anställda.',
        'no-students-accessible' => 'Hittade inga anställda som du har åtkomst till.',
    ]);
}

return $data;
