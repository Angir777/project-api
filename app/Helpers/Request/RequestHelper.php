<?php

namespace App\Helpers\Request;

class RequestHelper
{
    /**
     * Custom function that returns the number of elements on the page retrieved from the request query
     *
     * @return integer
     */
    public static function pageSize(): int
    {
        return request(
            config('query-builder.parameters.page_size'),
            config('query-builder.default_page_size')
        );
    }
}
