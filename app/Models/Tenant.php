<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tenant extends Model
{
    use Notifiable;

    protected $guarded = [];

    public function routeNotificationForTelegram(): ?string
    {
        return $this->telegram_id;
    }
}
