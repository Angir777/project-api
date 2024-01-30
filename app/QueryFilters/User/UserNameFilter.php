<?php

namespace App\QueryFilters\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Filters\Filter;

class UserNameFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(
            DB::raw("CONCAT(TRIM(`first_name`), ' ', TRIM(`last_name`))"),
            'like',
            "%$value%"
        )->orWhere(
            DB::raw("CONCAT(TRIM(`last_name`), ' ', TRIM(`first_name`))"),
            'like',
            "%$value%"
        );
    }
}
