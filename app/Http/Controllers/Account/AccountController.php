<?php

namespace App\Http\Controllers\Account;

use App\Helpers\Response\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ChangePasswordRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Account\AccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    protected $accountService;

    /**
     * @param AccountService $accountService
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * @param ChangePasswordRequest $request
     * 
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = $this->accountService->changePassword($request->validated());

        return ResponseHelper::response(new UserResource($user), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function daleteAccount(Request $request): JsonResponse
    {
        $user = $this->accountService->daleteAccount();

        return ResponseHelper::response(new UserResource($user), Response::HTTP_OK);
    }
}
