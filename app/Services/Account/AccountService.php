<?php

namespace App\Services\Account;

use App\Helpers\Response\ResponseHelper;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class AccountService
{
    /**
     * @param mixed $data
     * @return User
     */
    public function changePassword($data): User
    {
        // Czy taki użytkownik istnieje?
        $user = User::find(Auth::user()->id);
        if (!$user) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'CANT_FIND_USER'], Response::HTTP_NOT_FOUND)
            );
        }

        // Porównanie starego hasła
        $actualUserPassword = $user->password;
        if (!Hash::check($data['oldPassword'], $actualUserPassword)) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'WRONG_OLD_PASSWORD'], Response::HTTP_BAD_REQUEST)
            );
        }

        // Zmiana hasła
        $res = $user->update([
            'password' => Hash::make($data['password'])
        ]);
        if (!$res) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'CANT_CHANGE_PASSWORD'], Response::HTTP_BAD_REQUEST)
            );
        }

        return $user;
    }

    public function testSum($x, $y) {
        $res = $x + $y;
        return $res;
    }
}
