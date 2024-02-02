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

    'failed'   => 'Błędny login lub hasło.',
    'password' => 'Podane hasło jest nieprawidłowe.',
    'throttle' => 'Za dużo nieudanych prób logowania. Proszę spróbować za :seconds sekund.',

    'email' => [
        'regards' => 'Pozdrawiamy',
        'footer' => 'Jeśli masz problem z kliknięciem przycisku ":actionText", skopiuj poniższy adres URL i wklej go w przeglądarce internetowej:',
        'account_activate' => [
            'greeting' => 'Witaj na pokładzie!',
            'subject' => 'aktywacja konta',
            'line_hello' => 'Cieszymy się, że z nami jesteś :)',
            'line_password_info' => 'Twoje hasło do aplikacji',
            'is_password' => ' jest takie jakie zostało podane podczas rejestracji.',
            'line_activation_required' => 'Aby w pełni korzystać z aplikacji, musisz potwierdzić założenie swojego konta.',
            'action' => 'Potwierdzam!'
        ],
        'password_reset' => [
            'greeting' => 'Witaj!',
            'subject' => 'resetowanie hasła',
            'line_one' => 'Otrzymaliśmy prośbę o zresetowanie hasła.',
            'action' => 'Zresetuj swoje hasło',
            'line_two' => 'Link do resetowania hasła jest ważny 60 minut!'
        ]
    ],
];
