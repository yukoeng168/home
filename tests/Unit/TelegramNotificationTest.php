<?php

namespace Tests\Unit;

use App\Notifications\TenantNotification;
use NotificationChannels\Telegram\TelegramMessage;
use PHPUnit\Framework\TestCase;

class TelegramNotificationTest extends TestCase
{
    public function test_it_can_be_instantiated_with_a_message(): void
    {
        $notification = new TenantNotification('Hello World');
        $this->assertEquals('Hello World', $notification->message);
    }

    public function test_it_uses_the_telegram_channel(): void
    {
        $notification = new TenantNotification('Hello World');
        $this->assertEquals(['telegram'], $notification->via(new \stdClass()));
    }

    public function test_it_routes_to_the_correct_telegram_id(): void
    {
        $notifiable = new class {
            public function routeNotificationForTelegram() {
                return '123456789';
            }
        };

        $notification = new TenantNotification('Test Message');
        /** @var TelegramMessage $telegramMessage */
        $telegramMessage = $notification->toTelegram($notifiable);

        $payload = $telegramMessage->toArray();
        $this->assertEquals('123456789', $payload['chat_id']);
        $this->assertEquals('Test Message', $payload['text']);
    }
}
