<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PermissionGroup extends Model
{
    protected $fillable = [
        'name'
    ];

    /**
     * @return HasMany
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'permission_group_id', 'id');
    }
}
