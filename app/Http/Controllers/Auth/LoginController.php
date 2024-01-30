<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Response\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User\User;
use App\Services\Auth\LoginService;
use App\Services\Auth\LogoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    protected $loginService;
    protected $logoutService;

    /**
     * @param LoginService $loginService
     * @param LogoutService $logoutService
     */
    public function __construct(LoginService $loginService, LogoutService $logoutService)
    {
        $this->loginService = $loginService;
        $this->logoutService = $logoutService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->loginService->login(
            $request->only('email', 'password')
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        return ResponseHelper::response($this->logoutService->logout(), 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAdminsEmails(Request $request): JsonResponse
    {
        // Wyświetlenie na stronie logowania adresów email administratorów
        $adminEmails = User::whereHas(
            'roles', function($q){
                $q->where('name', config('access.roles.admin_role'));
            }
        )->pluck('email')->toArray();

        return ResponseHelper::response(join(", ", $adminEmails), Response::HTTP_OK);
    }
}
