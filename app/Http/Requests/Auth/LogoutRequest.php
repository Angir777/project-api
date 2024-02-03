<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseApiRequest;

class LogoutRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'revoke_all' => ['nullable', 'boolean'],
        ];
    }
}
