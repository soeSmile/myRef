<?php
declare(strict_types=1);

Route::group(['namespace' => 'Api'], static function () {
    // Вход и регистрация
    Route::post('login', 'Auth\ApiAuthController@login')->name('auth.login');

    /**
     * Public Routers
     */
    Route::group(['namespace' => 'Site'], static function () {
        Route::get('country', 'ApiPublicCountryController@index')->name('country.index');
        Route::get('city', 'ApiPublicCityController@index')->name('city.index');
        Route::get('parking', 'ApiPublicParkingController@index')->name('parking.index');
    });

    /**
     * Auth Routers
     */
    Route::group(['middleware' => 'auth'], static function () {
        // Auth Route
        Route::post('logout', 'Auth\ApiAuthController@logout')->name('auth.logout');
        Route::post('refresh', 'Auth\ApiAuthController@refresh')->name('auth.refresh');
        Route::post('me', 'Auth\ApiAuthController@me')->name('auth.me');
    });

    /**
     * Admin Routers
     */
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'is-user:admin'],
        static function () {
            Route::apiResource('users', 'ApiUserController')->except('destroy');
            Route::apiResource('countries', 'ApiCountryController')->except('destroy');
            Route::apiResource('cities', 'ApiCityController')->except('destroy');
            Route::apiResource('parkings', 'ApiParkingController')->except('destroy');
            Route::post('images/set-main', 'ApiImageController@setMainImage')->name('images.set-main');
            Route::apiResource('images', 'ApiImageController')->except('update');
            Route::apiResource('orders', 'ApiOrderController')->only('index, show');
        });
});
