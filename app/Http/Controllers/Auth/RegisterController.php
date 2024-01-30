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
     * Rejestracja używa serwisu od użytkownika. Po pomyślnej rejestracji
     * API zwraca odpowiedź i obiekt nowo utworzonego użytkownika.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        // Sprawdzenie czy użytkownicy mogą się rejestrować
        if (!config('access.registration')) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'REGISTRATION_DISABLED'], Response::HTTP_NOT_FOUND)
            );
        }

        // Tworzenie nowego użytkownika
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
