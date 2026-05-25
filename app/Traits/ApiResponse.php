<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Send a successful response
     */
    protected function successResponse($data = null, string $message = 'Operation successful', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
            'timestamp' => now()->toIso8601String(),
        ], $code);
    }

    /**
     * Send a paginated response
     */
    protected function paginatedResponse($items, string $message = 'Data retrieved successfully', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $items->items(),
            'pagination' => [
                'current_page' => $items->currentPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
                'last_page' => $items->lastPage(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
                'has_more' => $items->hasMorePages(),
            ],
            'message' => $message,
            'timestamp' => now()->toIso8601String(),
        ], $code);
    }

    /**
     * Send an error response
     */
    protected function errorResponse(string $message = 'Operation failed', array $errors = [], int $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => null,
            'message' => $message,
            'errors' => $errors,
            'timestamp' => now()->toIso8601String(),
        ], $code);
    }

    /**
     * Send a validation error response
     */
    protected function validationErrorResponse(array $errors, int $code = 422): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => null,
            'message' => 'Validation failed',
            'errors' => $errors,
            'timestamp' => now()->toIso8601String(),
        ], $code);
    }

    /**
     * Send an unauthorized response
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized', int $code = 401): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => null,
            'message' => $message,
            'timestamp' => now()->toIso8601String(),
        ], $code);
    }

    /**
     * Send a not found response
     */
    protected function notFoundResponse(string $message = 'Resource not found', int $code = 404): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => null,
            'message' => $message,
            'timestamp' => now()->toIso8601String(),
        ], $code);
    }
}
