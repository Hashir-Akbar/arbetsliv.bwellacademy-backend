<?php

$data = [
    'units' => 'Schools',
    'new' => 'New school',
    'show-staff' => 'Show staff',
    'show-sections' => 'Show classes',
    'school-type' => 'School type',
];

if (config('fms.type') == 'work') {
    $data = array_merge($data, [
        'units' => 'Companies',
        'new' => 'New company',
        'show-sections' => 'Show sections',
        'business-category' => 'Business category',
    ]);
}

return $data;
