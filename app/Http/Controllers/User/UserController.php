<?php

namespace App\Http\Controllers\User;

use App\Helpers\Response\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangeUserPasswordRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User\User;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
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
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function getAll(Request $request): JsonResponse
    {
        $data = $this->userService->getAll();

        return ResponseHelper::response(UserResource::collection($data), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function query(Request $request): JsonResponse
    {
        $page = $this->userService->query();

        return ResponseHelper::pageResponse(
            UserResource::collection($page->items()),
            $page->total(),
            $page->currentPage(),
            $page->perPage(),
            $page->lastPage(),
            Response::HTTP_OK
        );
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function queryDeleted(Request $request): JsonResponse
    {
        $page = $this->userService->queryDeleted();

        return ResponseHelper::pageResponse(
            UserResource::collection($page->items()),
            $page->total(),
            $page->currentPage(),
            $page->perPage(),
            $page->lastPage(),
            Response::HTTP_OK
        );
    }

    /**
     * @param Request $request
     * @param User $user
     * 
     * @return JsonResponse
     */
    public function getById(Request $request, User $user): JsonResponse
    {
        return ResponseHelper::response(new UserResource($user), Response::HTTP_OK);
    }

    /**
     * @param StoreUserRequest $request
     * 
     * @return JsonResponse
     */
    public function create(StoreUserRequest $request): JsonResponse
    {
        $res = $this->userService->create($request->validated());

        return ResponseHelper::response(new UserResource($res), Response::HTTP_OK);
    }

    /**
     * @param UpdateUserRequest $request
     * 
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $res = $this->userService->update($request->validated());

        return ResponseHelper::response(new UserResource($res), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param User $user
     * 
     * @return JsonResponse
     */
    public function delete(Request $request, User $user): JsonResponse
    {
        $this->userService->delete($user);

        return ResponseHelper::response(new UserResource($user), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param mixed $id
     * 
     * @return JsonResponse
     */
    public function restore(Request $request, $id): JsonResponse
    {
        $user = $this->userService->restore($id);

        return ResponseHelper::response(new UserResource($user), Response::HTTP_OK);
    }

    /**
     * @param ChangeUserPasswordRequest $request
     * @param User $user
     * 
     * @return JsonResponse
     */
    public function changePassword(ChangeUserPasswordRequest $request, User $user): JsonResponse
    {
        $user = $this->userService->changePassword(
            $user, 
            $request->only(
                'password'
            )
        );

        return ResponseHelper::response(new UserResource($user), Response::HTTP_OK);
    }
}
