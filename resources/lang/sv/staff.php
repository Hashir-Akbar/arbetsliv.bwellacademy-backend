<?php

$data = [
    'staff' => 'Personal',
    'new' => 'Ny personal',
    'show' => 'Visa',
    'show-all' => 'Visa alla',
    'select-unit' => 'Välj skola',
    'select-unit-info' => 'Välj en skola om du vill lägga till personal.',
    'permissions' => 'Behörigheter',
    'unit' => 'Skola',
    'twofactorauthentication-enabled' => '2FA aktiverat',
];

if (config('fms.type') == 'work') {
    $data = array_merge($data, [
        'select-unit' => 'Välj företag',
        'select-unit-info' => 'Välj ett företag om du vill lägga till personal.',
        'unit' => 'Företag',
    ]);
}

return $data;
