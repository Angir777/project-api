<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseApiRequest;

class ResetPasswordRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required',
            'password' => ['required', 'string', 'min:6', 'max:191', 'confirmed'],
            'token' => 'required'
        ];
    }
}
