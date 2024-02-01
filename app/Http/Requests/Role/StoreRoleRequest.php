<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\BaseApiRequest;

class StoreRoleRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'guardName' => 'required'
            // TODO
        ];
    }
}
