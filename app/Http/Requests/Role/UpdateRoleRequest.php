<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\BaseApiRequest;

class UpdateRoleRequest extends BaseApiRequest
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
            'name' => 'required',
            'guardName' => 'required',
            'permissionIds' => ['required', 'array']
        ];
    }
}
