<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

/**
 * Class BasicAuth
 * @package App\Http\Middleware
 */
class BasicAuth
{
    /**
     * Handle an incoming request.
     *confirm
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('email', $request->getUser())
            ->where('role', 'admin')
            ->first();

        if ($user && \Hash::check($request->getPassword(), $user->password)) {
            return $next($request);
        }

        return response('Unauthorized', 401, ['WWW-Authenticate' => 'Basic']);
    }
}
