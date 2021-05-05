<?php
declare(strict_types=1);

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

if (!function_exists('camelKeys')) {
    /**
     * @param array $array
     * @return array
     */
    function camelKeys(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = camelKeys($value);
            }
            $result[Str::camel($key)] = $value;
        }
        return $result;
    }
}

if (!function_exists('snakeKeys')) {
    /**
     * @param array $array
     * @param string $delimiter
     * @return array
     */
    function snakeKeys(array $array, string $delimiter = '_'): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = snakeKeys($value, $delimiter);
            }
            $result[Str::snake($key, $delimiter)] = $value;
        }
        return $result;
    }
}
