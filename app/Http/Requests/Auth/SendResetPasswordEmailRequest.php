<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseApiRequest;

class SendResetPasswordEmailRequest extends BaseApiRequest
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
            'gatewayUrl' => 'nullable'
        ];
    }
}
