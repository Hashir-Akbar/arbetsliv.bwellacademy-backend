<?php

$data = [
    'login' => 'Login for administrators',
    'email' => 'Email',
    'password' => 'Password',
    'forgot_password' => 'Forgot password?',
    'have_code' => 'I have a code',
    'fail' => 'Wrong email/password, please try again.',
];

if (config('fms.type') == 'work') {
    $data = array_merge($data, [
        'title' => 'Login for companies',
    ]);
}

return $data;
