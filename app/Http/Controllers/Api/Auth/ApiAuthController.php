<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserLoginResource;
use App\Mail\RegisterEmail;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Mail;
use Ramsey\Uuid\Uuid;

/**
 * Class ApiAuthController
 * @package App\Http\Controllers\Api\Auth
 */
final class ApiAuthController
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!$token = auth()->attempt([
            'email'    => $request->email,
            'password' => $request->password,
            'confirm'  => true
        ])) {
            return response()->json([
                'errors' => [
                    'auth' => trans('auth.failed')
                ]
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return UserLoginResource
     */
    public function me(): UserLoginResource
    {
        return new UserLoginResource(auth()->user());
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => bcrypt($request->password),
            'confirm_key' => Uuid::uuid6()->toString(),
        ]);

        Mail::to($user)->queue(new RegisterEmail($user));

        return response()->json(['data' => trans('auth.register')]);
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    private function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'token'     => $token,
            'expiresIn' => config('jwt.ttl'),
            'user'      => new UserLoginResource(auth()->user()),
        ]);
    }
}
