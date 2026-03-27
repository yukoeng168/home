<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_home_page_is_room93_and_has_telegram_widget(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('បន្ទប់ជួល ៩៣');
        $response->assertSee('telegram-widget.js');
    }
}
