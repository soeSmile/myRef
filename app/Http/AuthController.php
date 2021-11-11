<?php
declare(strict_types=1);

namespace App\Http;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class AuthController
 */
class AuthController
{
    /**
     * @param $key
     * @return Application|Factory|View
     */
    public function confirm($key): View|Factory|Application
    {
        $user = User::where('confirm_key', $key)->firstOrFail();

        $user->update([
            'confirm'     => true,
            'confirm_key' => null,
            'role'        => User::ROLE_CLIENT
        ]);

        return view('auth.confirm');
    }
}