<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends \Spatie\Permission\Models\Permission
{
    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(PermissionGroup::class, 'permission_group_id');
    }
}
