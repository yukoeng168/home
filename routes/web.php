<?php

use App\Http\Controllers\Auth\SilentLoginController;
use App\Http\Controllers\Auth\TelegramLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('room93');
});

Route::get('/auth/telegram/callback', [TelegramLoginController::class, 'handleCallback'])->name('auth.telegram.callback');
Route::post('/auth/telegram/silent-callback', [SilentLoginController::class, 'handle'])->name('auth.telegram.silent-callback');
