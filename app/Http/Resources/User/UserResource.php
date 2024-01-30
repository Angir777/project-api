<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Auth\PermissionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param mixed $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'emailVerifiedAt' => $this->email_verified_at,
            'confirmed' => (bool) $this->confirmed,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'deletedAt' => $this->deleted_at,
            'permissions' => $this->getAllPermissions() != null ? PermissionResource::collection($this->getAllPermissions()) : null,
            'roles' => $this->getRoleNames() != null ? $this->getRoleNames() : null,
        ];
    }
}
