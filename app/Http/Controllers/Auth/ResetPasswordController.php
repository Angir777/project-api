<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Response\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendResetPasswordEmailRequest;
use App\Models\User\User;
use App\Services\Auth\ResetPasswordService;
use Illuminate\Http\Exceptions\HttpResponseException;
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
     * Step 1
     * The user sends a request to the API to reset the password.
     * The request is sent from the APP, so we have its address and then return the link in the e-mail.
     * By clicking the link in the email, the user is taken back to the APP with a password reset view.
     *
     * @param SendResetPasswordEmailRequest $request
     * 
     * @return JsonResponse
     */
    public function sendResetPasswordEmail(SendResetPasswordEmailRequest $request): JsonResponse
    {
        // Redirection address in e-mail.
        $redirectUrl = $request->gatewayUrl ?? null;

        $user = User::where('email', 'like', $request->email)->first();

        if (!$user) {
            throw new HttpResponseException(
                ResponseHelper::response(['error' => 'USER_NOT_FOUND'], Response::HTTP_BAD_REQUEST)
            );
        }

        $this->resetPasswordService->sendResetPasswordEmail($user, $redirectUrl);

        return ResponseHelper::response('EMAIL_SEND', Response::HTTP_OK);
    }

    /**
     * Step 2
     * The user with an active token (the one sent in the e-mail) can change his current password
     *
     * @param ResetPasswordRequest $request
     * 
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $this->resetPasswordService->resetPassword($request->validated());

        return ResponseHelper::response('PASSWORD_CHANGED', Response::HTTP_OK);
    }
}
