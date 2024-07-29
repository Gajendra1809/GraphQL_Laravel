<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use GraphQL\Error\Error;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    // Other methods...

    public function render($request, Throwable $exception)
    {
        // $error = $this->formatGraphQLError($exception);
        // return response()->json([
        //     'errors' => [$error],
        // ], 200);

        return parent::render($request, $exception);
    }

    protected function formatGraphQLError(Throwable $exception): array
    {
        return [
            'message' => $exception->getMessage(),
            'extensions' => [
                'category' => 'custom',
                'code' => $exception->getCode(),
                'status' => 400, // or another status code
                // Add more custom fields as needed
            ],
        ];
    }
}
