<?php

$data = [
    'superadmin' => 'SuperAdmin',
    'staff' => 'Staff',
    'student' => 'Student',
    'test-student' => 'Teststudent',
    'admin' => 'Administrator',
    'nurse' => 'Nurse',
    'physical_trainer' => 'Physical trainer',
];

if (config('fms.type') == 'work') {
    $data['student'] = 'Employee';
    $data['test-student'] = 'Testemployee';
}

return $data;
