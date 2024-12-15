<?php
namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    protected function jsonResponse($data, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'status_code' => $statusCode,
        ], $statusCode);
    }

    protected function jsonError(string $message, int $statusCode = 400, array $errors = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'status_code' => $statusCode,
        ], $statusCode);
    }
}
