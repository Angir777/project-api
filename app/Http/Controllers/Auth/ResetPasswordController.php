<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Response\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendResetPasswordEmailRequest;
use App\Models\User\User;
use App\Services\Auth\ResetPasswordService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    protected $resetPasswordService;

    /**
     * @param ResetPasswordService $resetPasswordService
     */
    public function __construct(ResetPasswordService $resetPasswordService)
    {
        $this->resetPasswordService = $resetPasswordService;
    }

    /**
     * Krok 1
     * Użytkownik wysyła prośbę do API o zresetowanie hasła.
     * Prośba wysyłana jest z APP więc mamy jej adres by potem dokonać zwrotu linka w mailu.
     * Użytkownik klikająć link w mailu zostaje spowrotem przeniesiony do APP na widok resetowania hasła.
     *
     * @param SendResetPasswordEmailRequest $request
     * @return JsonResponse
     */
    public function sendResetPasswordEmail(SendResetPasswordEmailRequest $request): JsonResponse
    {
        // Adres do przekierowania w mailu.
        $redirectUrl = $request->gatewayUrl ?? null;

        $user = User::where('email', 'like', $request->email)->first();

        if (!$user) {
            return ResponseHelper::response('USER_NOT_FOUND', Response::HTTP_OK);
        }

        $this->resetPasswordService->sendResetPasswordEmail($user, $redirectUrl);

        return ResponseHelper::response('EMAIL_SEND', Response::HTTP_OK);
    }

    /**
     * Krok 2
     * Użytkownik mający aktywny token (ten przesłany w mailu) może zmienić swoje aktualne hasło
     *
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $this->resetPasswordService->resetPassword($request->email, $request->token, $request->password);

        return ResponseHelper::response('PASSWORD_CHANGED', Response::HTTP_OK);
    }
}
