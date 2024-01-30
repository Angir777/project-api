<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseApiRequest;

class ChangeUserPasswordRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'password' => 'required|string|min:6|max:191|confirmed',
        ];
    }
}
