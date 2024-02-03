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
     * @param mixed $data
     * 
     * @return array
     */
    public function logout($data): array
    {
        $user = Auth::user();

        // The user makes decisions
        if (isset($data['revoke_all'])) {
            $revokeAll = $data['revoke_all'];

            if ($revokeAll) {
                $this->revokeAllDevices($user);
            } else {
                $this->revokeCurrentDevice($user);
            }
        } else {
            // Automatically based on application settings
            if (!config('auth.on_logout_revoke_all_tokens')) {
                $this->revokeCurrentDevice($user);
            } else {
                $this->revokeAllDevices($user);
            }
        }

        return ['message' => 'Successfully logged out!'];
    }

    /**
     * @param mixed $user
     */
    private function revokeAllDevices($user) {
        // Log out of all devices
        $tokens = $user->tokens->pluck('id');
        Token::whereIn('id', $tokens)->update(['revoked' => true]);
        RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);
    }

    /**
     * @param mixed $user
     */
    private function revokeCurrentDevice($user) {
        // Log out only from the current device (other tokens remain active)
        $userToken = $user->token();
        $userToken->revoke();
    }
}
