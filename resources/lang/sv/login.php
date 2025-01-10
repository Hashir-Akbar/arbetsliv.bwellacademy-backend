<?php

$data = [
    'title' => 'Inloggning för administratörer',
    'login' => 'Logga in',
    'email' => 'Email',
    'password' => 'Lösenord',
    'forgot_password' => 'Glömt lösenord?',
    'have_code' => 'Jag har en kod',
    'fail' => 'Fel email/lösenord, försök igen.',
];

if (config('fms.type') == 'work') {
    $data = array_merge($data, [
        'title' => 'Inloggning för företag',
    ]);
}

return $data;
