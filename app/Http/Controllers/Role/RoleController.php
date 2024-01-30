<?php

namespace App\Http\Controllers\Role;

use App\Helpers\Response\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Auth\PermissionResource;
use App\Http\Resources\Role\RoleResource;
use App\Models\Auth\Permission;
use App\Models\Role\Role;
use App\Services\Role\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    protected $roleService;

    /**
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getAll(Request $request): JsonResponse
    {
        $data = $this->roleService->getAll();

        return ResponseHelper::response(RoleResource::collection($data), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function query(Request $request): JsonResponse
    {
        $page = $this->roleService->query();

        return ResponseHelper::pageResponse(
            RoleResource::collection($page->items()),
            $page->total(),
            $page->currentPage(),
            $page->perPage(),
            $page->lastPage(),
            Response::HTTP_OK
        );
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return JsonResponse
     */
    public function getById(Request $request, Role $role): JsonResponse
    {
        return ResponseHelper::response(new RoleResource($role), Response::HTTP_OK);
    }

    /**
     * @param StoreRoleRequest $request
     * @return JsonResponse
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        $role = $this->roleService->create($request->only(
            'name',
            'guardName',
            'permissionIds'
        ));

        return ResponseHelper::response(new RoleResource($role), Response::HTTP_OK);
    }

    /**
     * @param UpdateRoleRequest $request
     * @return JsonResponse
     */
    public function update(UpdateRoleRequest $request): JsonResponse
    {
        $role = $this->roleService->update(
            $request->only(
                'id',
                'name',
                'guardName',
                'permissionIds'
            )
        );

        return ResponseHelper::response(new RoleResource($role), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return JsonResponse
     */
    public function delete(Request $request, Role $role): JsonResponse
    {
        $role = $this->roleService->delete($role);

        return ResponseHelper::response(new RoleResource($role), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getPermissions(Request $request): JsonResponse
    {
        $permissions = Permission::with('group')->get();

        return ResponseHelper::response(PermissionResource::collection($permissions), Response::HTTP_OK);
    }
}
