<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class LogoutService
{
    /**
     * Logging out of the application
     *
     * @return string[]
     */
    public function logout(): array
    {
        $user = Auth::user();
        
        if (!config('auth.on_logout_revoke_all_tokens')) {
            // Log out only from the current device (other tokens remain active)
            $userToken = $user->token();
            $userToken->revoke();
        } else {
            // Log out of all devices
            $tokens = $user->tokens->pluck('id');
            Token::whereIn('id', $tokens)->update(['revoked' => true]);
            RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);
        }

        return ['message' => 'Successfully logged out!'];
    }
}
