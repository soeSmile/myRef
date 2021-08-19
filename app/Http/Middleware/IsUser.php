<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class IsUser
 * @package App\Http\Middleware
 */
class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        $check = match ($role) {
            'client' => isClient(),
            'admin' => isAdmin(),
            default => false,
        };

        if (!$check) {
            return response()->json([
                'errors' => trans('data.warning.unauthorized')
            ], 403);
        }

        return $next($request);
    }
}
