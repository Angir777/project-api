<?php

namespace App\Services\Account;

use App\Enums\Auth\PermissionNamesEnum;
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
     * 
     * @return User
     */
    public function changePassword($data): User
    {
        // Does the user exist?
        $user = User::find(Auth::user()->id);

        if (!$user) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'CANT_FIND_USER'], Response::HTTP_NOT_FOUND)
            );
        }

        // Old password comparison
        $actualUserPassword = $user->password;
        
        if (!Hash::check($data['oldPassword'], $actualUserPassword)) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'WRONG_OLD_PASSWORD'], Response::HTTP_BAD_REQUEST)
            );
        }

        // Password change
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

    /**
     * @return User
     */
    public function daleteAccount(): User
    {
        $user = Auth::user();

        if ($user->hasPermissionTo(PermissionNamesEnum::SUPER_ADMIN)) {
            
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'CANT_DELETE_SUPER_ADMIN_ACCOUNT'], Response::HTTP_NOT_FOUND)
            );

        }

        // Does the user exist?
        $user = User::find(Auth::user()->id);

        if (!$user) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'CANT_FIND_USER'], Response::HTTP_NOT_FOUND)
            );
        }

        // Soft delete account
        $res = $user->delete();

        if (!$res) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'CANT_DELETE'], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        return $user;
    }
}
