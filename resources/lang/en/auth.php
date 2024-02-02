<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',


    'email' => [
        'regards' => 'Best regards',
        'footer' => 'If you\'re having trouble clicking the :actionText button, copy the URL below and paste it into your web browser:',
        'account_activate' => [
            'greeting' => 'Welcome on board!',
            'subject' => 'account activation',
            'line_hello' => 'We are glad that you are with us :)',
            'line_password_info' => 'Your app password',
            'is_password' => ' is as provided during registration.',
            'line_activation_required' => 'To fully use the application, you must confirm the creation of your account.',
            'action' => 'I confirm!'
        ],
        'password_reset' => [
            'greeting' => 'Hello!',
            'subject' => 'password reset',
            'line_one' => 'We have received a request to reset your password.',
            'action' => 'Reset your password',
            'line_two' => 'The password reset link is valid for 60 minutes!'
        ]
    ],
];
