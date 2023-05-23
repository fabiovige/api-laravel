<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\MessageBag;

trait HttpResponses
{
    public function response(string $message, string|int $status, array|Model|JsonResource $data = [])
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function errors(string $message, string|int $status, array|MessageBag $errors = [], array $data = [])
    {
        return response()->json([
            'status' => $status,
            'errors' => $errors,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
