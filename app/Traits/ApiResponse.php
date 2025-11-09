<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\AbstractPaginator;

trait ApiResponse
{
    /**
     * Standardized error response
     *
     * @param string $msg
     * @param int $code
     * @return JsonResponse
     */
    public function responseError($msg, $code = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'code' => $code,
            'message' => $msg,
        ], $code);
    }

    /**
     * Standardized success response
     *
     * @param mixed $data
     * @param string $msg
     * @param int $code
     * @return JsonResponse
     */
    public function responseSuccess(mixed $data = [], string $msg = '', int $code = 200): JsonResponse
    {
        $isPaginated = $data instanceof AbstractPaginator;
        $response = [
            'status'    => 'success',
            'message'   => $msg,
            'data'      => $isPaginated ? $data->items() : $data,
        ];

        if ($isPaginated) {
            $response['meta']['pagination'] = [
                'total'        => $data->total(),
                'per_page'     => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page'    => $data->lastPage(),
                'from'         => $data->firstItem(),
                'to'           => $data->lastItem(),
                'links'        => [
                    'first' => $data->url(1),
                    'last'  => $data->url($data->lastPage()),
                    'prev'  => $data->previousPageUrl(),
                    'next'  => $data->nextPageUrl(),
                ],
            ];
        }

        return response()->json($response, $code);
    }

    /**
     * Standardized success message response
     *
     * @param string $msg
     * @param int $code
     * @return JsonResponse
     */
    public function responseSuccessMsg($msg = '', $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $msg,
        ], $code);
    }
}
