<?php

namespace App\QueryFilters\User;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class UserRolesFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // Sprawdź, czy wartość filtra nie jest pusta i jest tablicą
        if (!empty($value) && is_array($value)) {
            $query->whereHas('roles', function (Builder $q1) use ($value) {
                $q1->whereIn('name', $value);
            });
        } elseif (!empty($value)) {
            // Jeśli wartość filtra jest pojedynczą rolą (nie tablicą)
            $query->whereHas('roles', function (Builder $q1) use ($value) {
                $q1->where('name', 'like', $value);
            });
        }
    }
}
