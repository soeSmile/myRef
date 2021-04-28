<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return JsonResponse
     */
    protected function redirectTo($request): JsonResponse
    {
        if (!$request->expectsJson()) {
            abort(404);
        }

        return response()->json('Unauthorized', 401);
    }
}
