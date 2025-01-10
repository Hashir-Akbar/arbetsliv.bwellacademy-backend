<?php

$data = [
    'start' => 'Startpage',
    'units' => 'Schools',
    'staff' => 'Staff',
    'sections' => 'Classes',
    'students' => 'Students',
    'stats' => 'Statistics',
    'student-questions' => 'Student questions',
    'test-profile' => 'Lifestyle plan - test',
    'help' => 'Help',
    'logged_in_as' => 'Logged in as',
    'logout' => 'Log out',
    'search' => 'Search',
    'questionnaire' => 'Questionnaire',
    'users' => 'Users',
    'groups' => 'User groups',
    'sample' => 'Sample groups',
    'analysis' => 'Lifestyle analysis',
    'results' => 'Results lifestyle analysis',
    'goals' => 'Lifestyle goals',
    'plan' => 'Lifestyle plan',
    'compare' => 'Comparisons',
];

if (config('fms.type') == 'work') {
    $data = array_merge($data, [
        'units' => 'Companies',
        'sections' => 'Sections',
        'students' => 'Employees',
        'student-questions' => 'Employee questions',
    ]);
}

return $data;
