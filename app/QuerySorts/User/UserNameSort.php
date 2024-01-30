<?php

namespace App\QuerySorts\User;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class UserNameSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';

        $query->orderBy('first_name', $direction)
            ->orderBy('last_name', $direction)
            ->select('users.*');
    }
}
