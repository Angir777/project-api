<?php

namespace App\QueryFilters\User;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class UserRolesFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // Check that the filter value is not empty and is an array
        if (!empty($value) && is_array($value)) {
            $query->whereHas('roles', function (Builder $q) use ($value) {
                $q->whereIn('name', $value);
            });
        } elseif (!empty($value)) {
            // If the filter value is a single role (not an array)
            $query->whereHas('roles', function (Builder $q) use ($value) {
                $q->where('name', 'like', $value);
            });
        }
    }
}
