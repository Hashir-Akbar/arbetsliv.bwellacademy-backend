<?php

$data = [
    'staff' => 'Staff',
    'new' => 'New staff',
    'show' => 'Show',
    'show-all' => 'Show all',
    'select-unit' => 'Select school',
    'select-unit-info' => 'Select a school if you want to add staff.',
    'permissions' => 'Permissions',
    'unit' => 'School',
    'twofactorauthentication-enabled' => '2FA enabled',
];

if (config('fms.type') == 'work') {
    $data = array_merge($data, [
        'select-unit' => 'Select company',
        'select-unit-info' => 'Select a company if you want to add staff.',
        'unit' => 'Company',
    ]);
}

return $data;
