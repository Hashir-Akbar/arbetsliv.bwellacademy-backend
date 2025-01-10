<?php

$data = [
    'superadmin' => 'SuperAdmin',
    'staff' => 'Personal',
    'student' => 'Elev',
    'test-student' => 'Testelev',
    'admin' => 'Administratör',
    'nurse' => 'Sjuksköterska',
    'physical_trainer' => 'Idrottslärare',
];

if (config('fms.type') == 'work') {
    $data['student'] = 'Anställd';
    $data['test-student'] = 'Testanställd';
    $data['nurse'] = 'Sköterska';
}

return $data;
