<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseApiRequest;

class UpdateUserRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required',
            'name' => ['required', 'string', 'max:191'],
            'email' => 'required|string|email|unique:users,email,' . $this->get('id'),
            'confirmed' => 'required',
            'roles' => ['nullable', 'array']
        ];
    }
}
