<?php

$data = [
    'start' => 'Startsida',
    'units' => 'Skolor',
    'staff' => 'Personal',
    'sections' => 'Klasser',
    'students' => 'Elever',
    'stats' => 'Statistik',
    'student-questions' => 'Elevprofilsfrågor',
    'test-profile' => 'Livsstilsplan - test',
    'help' => 'Hjälp',
    'logged_in_as' => 'Inloggad som',
    'logout' => 'Logga ut',
    'search' => 'Sök',
    'questionnaire' => 'Enkät',
    'users' => 'Användare',
    'groups' => 'Användargrupper',
    'sample' => 'Skolans egna grupper',
    'analysis' => 'Livsstilsanalys',
    'results' => 'Resultat livsstilsanalys',
    'goals' => 'Livsstilsmål',
    'plan' => 'Livsstilsplan',
    'compare' => 'Jämförelser',
];

if (config('fms.type') == 'work') {
    $data = array_merge($data, [
        'units' => 'Företag',
        'sections' => 'Avdelningar',
        'students' => 'Anställda',
        'student-questions' => 'Vuxenfrågor',
        'sample' => 'Företagets egna grupper',
    ]);
}

return $data;
