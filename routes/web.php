<?php

use App\Http\AuthController;
use App\Http\Controllers\DownloadController;
use Illuminate\Support\Facades\Route;

Route::get('sys/confirm/{key}', [AuthController::class, 'confirm'])
    ->name('auth.confirm')
    ->whereUuid('key');

Route::get('sys/note/download/{id}', [DownloadController::class, 'getAttachNote'])->name('note.attache');