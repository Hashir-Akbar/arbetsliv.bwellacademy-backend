<?php

$data = [
    'units' => 'Skolor',
    'new' => 'Ny skola',
    'show-staff' => 'Visa personal',
    'show-sections' => 'Visa klasser',
    'school-type' => 'Skolform',
];

if (config('fms.type') == 'work') {
    $data = array_merge($data, [
        'units' => 'Företag',
        'new' => 'Nytt företag',
        'show-sections' => 'Visa avdelningar',
        'business-category' => 'Bransch',
    ]);
}

return $data;
