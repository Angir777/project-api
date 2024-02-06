<?php

namespace App\Services\Auth;

use App\Helpers\Response\ResponseHelper;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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
    public function logout($data): JsonResponse
    {
        $user = Auth::user();

        // The user makes decisions
        if (isset($data['revoke_all'])) {
            // User choice
            if ($data['revoke_all']) {
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

        throw new HttpResponseException(
            ResponseHelper::response(['success' => 'LOGGED_OUT'], Response::HTTP_OK)
        );
    }

    /**
     * @param mixed $user
     */
    private function revokeAllDevices($user)
    {
        // Log out of all devices
        $tokens = $user->tokens->pluck('id');
        Token::whereIn('id', $tokens)->update(['revoked' => true]);
        RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);
    }

    /**
     * @param mixed $user
     */
    private function revokeCurrentDevice($user)
    {
        // Log out only from the current device (other tokens remain active)
        $userToken = $user->token();
        $userToken->revoke();
    }
}
