<?php

namespace App\Services\Role;

use App\Helpers\Request\RequestHelper;
use App\Models\Auth\Permission;
use App\Models\Role\Role;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class RoleService
{
    /**
     * @return array
     */
    protected function allowedSorts(): array
    {
        return [
            AllowedSort::field('id', 'id'),
            AllowedSort::field('name', 'name'),
            AllowedSort::field('guardName', 'guard_name'),
            AllowedSort::field('createdAt', 'created_at'),
            AllowedSort::field('updatedAt', 'updated_at'),
        ];
    }

    /**
     * @return array
     */
    protected function allowedFilters(): array
    {
        return [
            AllowedFilter::exact('id', 'id'),
            AllowedFilter::exact('name', 'name'),
            AllowedFilter::partial('guardName', 'guard_name'),
            AllowedFilter::partial('createdAt', 'created_at'),
            AllowedFilter::partial('updatedAt', 'updated_at'),
        ];
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return QueryBuilder::for(Role::query())
            ->defaultSort('id')
            ->allowedSorts($this->allowedSorts())
            ->allowedFilters($this->allowedFilters())
            ->get();
    }

    /**
     * @return Paginator
     */
    public function query(): Paginator
    {
        return QueryBuilder::for(Role::query())
            ->defaultSort('id')
            ->allowedSorts($this->allowedSorts())
            ->allowedFilters($this->allowedFilters())
            ->paginate(RequestHelper::pageSize());
    }

    /**
     * @param mixed $data
     * 
     * @return Role
     */
    public function create($data): Role
    {
        return DB::transaction(function () use ($data) {
            $role = Role::create([
                'name' => $data['name'],
                'guard_name' => $data['guardName']
            ]);

            if (!$role) {
// todo zobacz w account jak zwracane sa błedy
                throw new HttpResponseException(
                    response()->json(['error' => 'CANT_CREATE_ROLE'], Response::HTTP_UNPROCESSABLE_ENTITY)
                );
            }

            // Association with selected permissions
            foreach ($data['permissionIds'] as $permissionId) {
                $permission = Permission::find($permissionId);

                if (!$permission) {
                    throw new HttpResponseException(response()->json(['error' => 'PERMISSION_NOT_FOUND'], Response::HTTP_UNPROCESSABLE_ENTITY));
                }

                $role->givePermissionTo($permission);
            }

            return $role;
        });
    }

    /**
     * @param mixed $data
     * 
     * @return Role
     */
    public function update($data): Role
    {
        return DB::transaction(function () use ($data) {
            $role = Role::find($data['id']);

            if ($role == null) {
                throw new HttpResponseException(
                    response()->json(['message' => 'ROLE_NOT_FOUND'], Response::HTTP_BAD_REQUEST)
                );
            }

            $res = $role->update([
                'name' => $data['name'],
                'guard_name' => $data['guardName']
            ]);

            if (!$res) {
                throw new HttpResponseException(
                    response()->json(['error' => 'CANT_UPDATE_ROLE'], Response::HTTP_UNPROCESSABLE_ENTITY)
                );
            }

            // Removal of old permission associations
            $role->syncPermissions();

            // Association with selected permissions
            foreach ($data['permissionIds'] as $permissionId) {
                $permission = Permission::find($permissionId);

                if (!$permission) {
                    throw new HttpResponseException(
                        response()->json(['error' => 'PERMISSION_NOT_FOUND'], Response::HTTP_UNPROCESSABLE_ENTITY)
                    );
                }

                $role->givePermissionTo($permission);
            }

            return $role;
        });
    }

    /**
     * @param Role $role
     * 
     * @return Role
     */
    public function delete(Role $role): Role
    {
        $res = $role->delete();
        
        if (!$res) {
            throw new HttpResponseException(
                response()->json(['error' => 'CANT_DELETE'], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        return $role;
    }
}
