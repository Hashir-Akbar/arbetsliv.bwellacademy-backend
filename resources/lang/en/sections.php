<?php

$data = [
    'sections' => 'Classes',
    'new' => 'New class',
    'show' => 'Show',
    'show-all' => 'Show all',
    'select-unit' => 'Select school',
    'select-unit-info' => 'Select a school if you want to add classes.',
    'show-students' => 'Show students',
    'archived' => 'Archived',

    'unit' => 'School',

    'school_year' => 'Grade',
    'program' => 'Programme',
    'completed' => 'Completed',
];

if (config('fms.type') == 'work') {
    $data = array_merge($data, [
        'sections' => 'Sections',
        'new' => 'New sections',
        'select-unit' => 'Select company',
        'select-unit-info' => 'Select a company if you want to add sections.',
        'show-students' => 'Show employees',

        'unit' => 'Company',
    ]);
}

return $data;
