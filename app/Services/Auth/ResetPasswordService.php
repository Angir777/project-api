<?php

namespace App\Services\Auth;

use App\Models\Auth\PasswordReset;
use App\Models\User\User;
use App\Notifications\Auth\UserPasswordResetNotification;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\Response\ResponseHelper;

class ResetPasswordService
{
    /**
     * @param User $user
     * @param mixed $redirectUrl
     * 
     * @return User
     */
    public function sendResetPasswordEmail(User $user, $redirectUrl): User
    {
        $passwordReset = PasswordReset::where('email', '=', $user->email)->first();

        if ($passwordReset) {
            $passwordReset->token = Str::random(60);
            $passwordReset->save();
        } else {
            $passwordReset = PasswordReset::create([
                'email' => $user->email,
                'token' => Str::random(60)
            ]);
        }

        if ($passwordReset) {
            $user->notify((new UserPasswordResetNotification($user, $passwordReset, $redirectUrl))->locale(app()->getLocale()));
        }

        return $user;
    }

    /**
     * @param mixed $data
     * 
     * @return User
     */
    public function resetPassword($data): User
    {
        $passwordReset = PasswordReset::where([
            ['token', '=', $data['token']],
            ['email', '=', $data['email']]
        ])->first();

        if (!$passwordReset) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'TOKEN_INVALID'], Response::HTTP_BAD_REQUEST)
            );
        }

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(config('auth.passwords.users.expire'))->isPast()) {
            $passwordReset->delete();

            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'TOKEN_EXPIRED'], Response::HTTP_BAD_REQUEST)
            );
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'USER_NOT_FOUND'], Response::HTTP_BAD_REQUEST)
            );
        }

        $res = $user->update([
            'password' => Hash::make($data['password']),
        ]);

        if (!$res) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'CANT_RESET_PASSWORD'], Response::HTTP_BAD_REQUEST)
            );
        }

        $passwordReset->delete();

        return $user;
    }
}
