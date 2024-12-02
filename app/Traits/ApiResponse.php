<?php

namespace App\Traits;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait ApiResponse
{

    public function successResponse(mixed $data, int $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data
        ], $statusCode);
    }

    public function errorResponse(Exception $e)
    {
        if ($e instanceof HttpException) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $e->getStatusCode());
        }

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
