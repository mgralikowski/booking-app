<?php

declare(strict_types=1);

namespace App\Modules\Misc\Responses;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;

class ApiResponse
{
    /**
     * Create a success JSON response.
     */
    public static function success(mixed $data = null, string $message = ''): JsonResponse
    {
        return self::createResponse(true, ResponseCodes::HTTP_OK, $message, $data, ResponseCodes::HTTP_OK);
    }

    /**
     * Create a created JSON response.
     */
    public static function created(mixed $data = null, string $message = ''): JsonResponse
    {
        return self::createResponse(true, ResponseCodes::HTTP_CREATED, $message, $data, ResponseCodes::HTTP_CREATED);
    }

    /**
     * Create an error JSON response.
     */
    public static function error(string $message = 'An error occurred.', $data = null, int $code = ResponseCodes::HTTP_INTERNAL_SERVER_ERROR, int $status = ResponseCodes::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return self::createResponse(false, $code, $message, $data, $status);
    }

    /**
     * Create a not found JSON response.
     */
    public static function notFound(string $message = 'Resource not found.'): JsonResponse
    {
        return self::error($message, null, 404, 404);
    }

    /**
     * Create a standard JSON response.
     */
    public static function createResponse(bool $success, int $code = 200, string $message = '', $data = null, int $status = 200): JsonResponse
    {
        $response = [
            'success' => $success,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $status);
    }
}
