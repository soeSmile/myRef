<?php

use App\Http\Controllers\DownloadController;
use Illuminate\Support\Facades\Route;

Route::get('sys/note/download/{id}', [DownloadController::class, 'getAttachNote'])->name('');