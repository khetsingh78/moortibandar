<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class ShiprocketWebhookTest extends TestCase
{
    public function test_it_rejects_webhooks_with_an_invalid_token(): void
    {
        config(['services.shiprocket.webhook_token' => 'configured-long-random-token']);

        $this->postJson('/api/webhooks/shiprocket/not-the-token')
            ->assertUnauthorized();
    }

    public function test_it_ignores_webhooks_without_a_shipment_reference(): void
    {
        config(['services.shiprocket.webhook_token' => 'configured-long-random-token']);

        $this->postJson('/api/webhooks/shiprocket/configured-long-random-token', [])
            ->assertOk()
            ->assertJson(['status' => 'ignored']);
    }

    public function test_shipment_actions_remain_protected_by_admin_middleware(): void
    {
        foreach (['orders.shiprocket.couriers', 'orders.shiprocket.store'] as $routeName) {
            $route = Route::getRoutes()->getByName($routeName);

            $this->assertNotNull($route);
            $this->assertContains('auth', $route->middleware());
            $this->assertContains('hasRole', $route->middleware());
        }
    }
}