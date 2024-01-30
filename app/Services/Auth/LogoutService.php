<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class LogoutService
{
    /**
     * Wylogowanie z aplikacji
     *
     * @return string[]
     */
    public function logout(): array
    {
        $user = Auth::user();
        if (!config('auth.on_logout_revoke_all_tokens')) {
            // Wylogowanie tylko z aktualnego urządzenia (pozostałe tokeny zostają aktywne)
            $userToken = $user->token();
            $userToken->revoke();
        } else {
            // Wylogowanie ze wszystkich urządzeń
            $tokens = $user->tokens->pluck('id');
            Token::whereIn('id', $tokens)->update(['revoked' => true]);
            RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);
        }

        return ['message' => 'Successfully logged out!'];
    }
}
