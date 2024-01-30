<?php

return [
    'confirm_email' => env('CONFIRM_EMAIL', true),
    'registration' => env('REGISTRATION', true),
    'roles' => [
        'super_admin_role' => 'SUPER_ADMIN',
        'admin_role' => 'ADMIN',
        'user_role' => 'USER',
    ],
    'default_guard_name' => 'web',
];
