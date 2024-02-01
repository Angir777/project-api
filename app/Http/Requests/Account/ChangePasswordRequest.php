<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\BaseApiRequest;

class ChangePasswordRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'oldPassword' => 'required',
            'password' => ['required', 'string', 'min:6', 'max:191', 'confirmed'],
        ];
    }
}
