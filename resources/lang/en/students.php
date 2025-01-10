<?php

$data = [
    'students' => 'Students',
    'new' => 'Add students',
    'import' => 'Import students',
    'show' => 'Show',
    'show-multiple' => 'Show students',
    'show-all' => 'Show all',
    'select-section' => 'Select class',
    'select-section-info' => 'Select a class if you want to add students.',

    'unit' => 'School',
    'section' => 'Class',

    'code' => 'Reg.code',
    'codes' => 'Reg.codes',

    'no-students' => 'No students found.',
    'no-students-accessible' => 'No students found that you have access to.',
];

if (config('fms.type') == 'work') {
    $data = array_merge($data, [
        'students' => 'Employee',
        'new' => 'New employees',
        'import' => 'Import employees',
        'show' => 'Show',
        'show-multiple' => 'Show employees',
        'show-all' => 'Show all',
        'select-section' => 'Select section',
        'select-section-info' => 'Select a section if you want to add employees.',
        'unit' => 'Company',
        'section' => 'Section',
        'no-students' => 'No employees found.',
        'no-students-accessible' => 'No employees found that you have access to.',
    ]);
}

return $data;
