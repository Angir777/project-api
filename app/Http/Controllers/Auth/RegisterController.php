<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Response\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    protected $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Registration uses the website from the user. After successful registration
     * the API returns the response and object of the newly created user.
     *
     * @param RegisterRequest $request
     * 
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // Check if users can register
        if (!config('access.registration')) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'REGISTRATION_DISABLED'], Response::HTTP_NOT_FOUND)
            );
        }

        // Acceptance regulations
        if (!isset($request['acceptance_regulations']) || (
            (isset($request['acceptance_regulations'])) && !$request['acceptance_regulations']
        )) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'YOU_DONT_ACCEPTANCE_REGULATIONS'], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        // Creating a new user
        $data = $this->userService->create($request->validated());

        return ResponseHelper::response(new UserResource($data), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param mixed $confirmationCode
     *
     * @return JsonResponse
     */
    public function confirmAccount(Request $request, $confirmationCode): JsonResponse
    {
        $this->userService->confirmAccount($confirmationCode);

        return ResponseHelper::response(['msg' => 'CONFIRMED'], Response::HTTP_OK);
    }
}
