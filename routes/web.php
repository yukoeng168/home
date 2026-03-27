<?php

use App\Http\Controllers\Auth\TelegramLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('room93');
});

Route::get('/auth/telegram/callback', [TelegramLoginController::class, 'handleCallback'])->name('auth.telegram.callback');
