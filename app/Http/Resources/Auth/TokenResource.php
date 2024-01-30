<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
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
            'accessToken' => $this->accessToken,
            'expiresAt' => $this->token->expires_at,
            'updatedAt' => $this->token->updated_at,
            'revoked' => $this->token->revoked,
        ];
    }
}
