<?php

namespace App\QueryFilters\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\Filters\Filter;

class UserDateDeleteFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        // Ensure that the column name is correct
        $property = 'deleted_at';

        // Define possible formats
        $dateTimeFormat = 'd-m-Y H:i:s';
        $dateFormat = 'd-m-Y';
        $timeFormat = 'H:i:s';

        // Check if the input matches a full datetime format
        if (Carbon::hasFormat($value, $dateTimeFormat)) {
            $date = Carbon::createFromFormat($dateTimeFormat, $value);
            $formattedValue = $date->format('Y-m-d H:i:s');
            $query->where($property, 'LIKE', $formattedValue . '%');
        }
        // Check if the input matches a date format
        elseif (Carbon::hasFormat($value, $dateFormat)) {
            $date = Carbon::createFromFormat($dateFormat, $value);
            $formattedValue = $date->format('Y-m-d');
            $query->where($property, 'LIKE', $formattedValue . '%');
        }
        // Check if the input matches a time format
        elseif (Carbon::hasFormat($value, $timeFormat)) {
            $time = Carbon::createFromFormat($timeFormat, $value);
            $formattedValue = $time->format('H:i:s');
            $query->where($property, 'LIKE', '%' . $formattedValue);
        }
        // This will force an empty result
        else {
            $query->whereRaw('1 = 0');
        }
    }
}
