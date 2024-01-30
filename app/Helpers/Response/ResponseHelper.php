<?php

namespace App\Helpers\Response;

use Illuminate\Http\JsonResponse;

abstract class ResponseHelper
{
    /**
     * @param mixed $data
     * @param mixed $status
     * @return JsonResponse
     */
    public static function response($data, $status): JsonResponse
    {
        return response()->json($data, $status);
    }

    /**
     * @param mixed $items
     * @param mixed $totalCount
     * @param mixed $status
     *
     * @return JsonResponse
     */
    public static function sortedResponse($items, $totalCount, $status): JsonResponse
    {
        return response()->json([
            'items' => $items,
            'total_count' => $totalCount
        ], $status);
    }

    /**
     * @param mixed $items
     * @param mixed $totalItems
     * @param mixed $page
     * @param mixed $pageSize
     * @param mixed $lastPage
     * @param mixed $status
     *
     * @return JsonResponse
     */
    public static function pageResponse($items, $totalItems, $page, $pageSize, $lastPage, $status): JsonResponse
    {
        return response()->json([
            'items' => $items,
            'totalCount' => $totalItems,
            'currentPage' => $page,
            'pageSize' => $pageSize,
            'lastPage' => $lastPage
        ], $status);
    }
}
