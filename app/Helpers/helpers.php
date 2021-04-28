<?php
declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Support\Str;

if (!function_exists('isAdmin')) {

    /**
     * @return bool
     */
    function isAdmin(): bool
    {
        if (auth()->check()) {
            return auth()->user()->isAdmin();
        }

        return false;
    }
}

if (!function_exists('isClient')) {

    /**
     * @return bool
     */
    function isClient(): bool
    {
        if (auth()->check()) {
            return auth()->user()->isClient();
        }

        return false;
    }
}
