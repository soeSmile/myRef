<?php
declare(strict_types=1);

use App\Http\Controllers\Api\Auth\ApiAuthController;

Route::group(['namespace' => 'Api'], static function () {
    // Вход и регистрация
    Route::post('login', [ApiAuthController::class, 'login'])->name('auth.login');

    /**
     * Auth Routers
     */
    Route::group(['middleware' => 'auth'], static function () {
        // Auth Route
        Route::post('logout', [ApiAuthController::class, 'logout'])->name('auth.logout');
        Route::post('refresh', [ApiAuthController::class, 'refresh'])->name('auth.refresh');
        Route::post('me', [ApiAuthController::class, 'me'])->name('auth.me');
    });
});
