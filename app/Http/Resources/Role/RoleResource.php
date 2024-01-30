<?php

namespace App\Http\Resources\Role;

use App\Http\Resources\Auth\PermissionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'guardName' => $this->guard_name,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'permissions' => $this->getAllPermissions() != null ? PermissionResource::collection($this->getAllPermissions()) : null,
        ];
    }
}
