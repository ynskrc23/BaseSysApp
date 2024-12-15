<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => $this->getMessage()], 400);
    }
}
