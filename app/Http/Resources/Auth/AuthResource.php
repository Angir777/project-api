<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param mixed $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'confirmed' => (bool) $this->confirmed,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'token' => $this->setToken(),
            'tokenType' => 'Bearer',
            'permissions' => $this->getAllPermissions() != null ? PermissionResource::collection($this->getAllPermissions()) : null,
            'roles' => $this->getRoleNames() != null ? $this->getRoleNames() : null,
        ];
    }

    public function setToken()
    {
        $user = Auth::user();
        $token = $user->createToken('TokenAPI')->accessToken;
        return $token;
    }
}
