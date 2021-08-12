<?php
declare(strict_types=1);

use App\Http\Controllers\Api\ApiCategoryController;
use App\Http\Controllers\Api\ApiLinkController;
use App\Http\Controllers\Api\ApiTagController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiUserSearchLinksController;
use App\Http\Controllers\Api\Auth\ApiAuthController;
use Illuminate\Support\Facades\Route;

// login
Route::post('login', [ApiAuthController::class, 'login'])->name('auth.login');

/**
 * Public Routers
 */
Route::apiResource('categories', ApiCategoryController::class)->only('index', 'show');
Route::apiResource('tags', ApiTagController::class)->only('index', 'show');
Route::apiResource('links', ApiLinkController::class)->only('index', 'show');

/**
 * Auth Routers
 */
Route::group(['middleware' => 'auth'], static function () {
    // Auth Route
    Route::post('logout', [ApiAuthController::class, 'logout'])->name('auth.logout');
    Route::post('refresh', [ApiAuthController::class, 'refresh'])->name('auth.refresh');
    Route::post('me', [ApiAuthController::class, 'me'])->name('auth.me');
    Route::apiResource('tags', ApiTagController::class)->only('store');
    Route::apiResource('links', ApiLinkController::class)->only('store', 'update');
    Route::apiResource('user-links', ApiUserSearchLinksController::class)->only('index', 'store', 'update', 'destroy');

    /**
     * Client Routers
     */
    Route::group(['middleware' => 'is-user:client'], static function () {

    });

    /**
     * Admin routers
     */
    Route::group(['middleware' => 'is-user:admin'], static function () {
        Route::apiResource('categories', ApiCategoryController::class)->only('store', 'update');
        Route::apiResource('tags', ApiTagController::class)->only('update');
        Route::apiResource('users', ApiUserController::class)->except('destroy');
    });
});
