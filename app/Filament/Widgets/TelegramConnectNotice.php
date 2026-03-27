<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class TelegramConnectNotice extends Widget
{
    protected string $view = 'filament.widgets.telegram-connect-notice';

    protected static bool $isLazy = false;

    public function visible(): bool
    {
        return Auth::user()->telegram_id === null;
    }
}
