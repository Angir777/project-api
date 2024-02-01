<?php

namespace App\Services\Auth;

use App\Helpers\Response\ResponseHelper;
use App\Http\Resources\Auth\AuthResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginService
{
    /**
     * @param mixed $data
     * 
     * @return JsonResponse
     */
    public function login($data): JsonResponse
    {
        if (Auth::attempt($data)) {
            $user = Auth::user();

            $user->token = $user->createToken('TokenAPI')->accessToken;

            return ResponseHelper::response(new AuthResource($user), Response::HTTP_OK);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}
