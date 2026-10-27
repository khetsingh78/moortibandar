<?php

namespace Tests\Unit;

use App\Models\Shipping;
use App\Services\Shiprocket\ShiprocketClient;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ShiprocketClientTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.shiprocket.base_url' => 'https://shiprocket.test/v1/external',
            'services.shiprocket.email' => 'store@example.test',
            'services.shiprocket.password' => 'test-password',
            'services.shiprocket.pickup_postcode' => '110001',
        ]);
        Cache::flush();
    }

    public function test_it_authenticates_and_normalizes_available_couriers(): void
    {
        Http::fake([
            '*auth/login' => Http::response([
                'token' => 'shiprocket-test-token',
                'expires_in' => 3600,
            ]),
            '*courier/serviceability*' => Http::response([
                'data' => [
                    'available_courier_companies' => [[
                        'courier_company_id' => 42,
                        'courier_name' => 'Example Express',
                        'freight_charge' => 87.5,
                        'estimated_delivery_days' => '2-4 days',
                    ]],
                ],
            ]),
        ]);

        $address = new Shipping(['zip' => '400001']);
        $couriers = app(ShiprocketClient::class)->availableCouriers($address, [
            'weight' => 1.25,
            'length' => 20,
            'breadth' => 15,
            'height' => 10,
        ], 'cod');

        $this->assertSame([
            [
                'id' => '42',
                'name' => 'Example Express',
                'rate' => 87.5,
                'estimated_delivery' => '2-4 days',
            ],
        ], $couriers);

        Http::assertSent(function (ClientRequest $request) {
            return str_ends_with($request->url(), '/auth/login')
                && $request['email'] === 'store@example.test';
        });
        Http::assertSent(function (ClientRequest $request) {
            return str_contains($request->url(), '/courier/serviceability/')
                && $request->hasHeader('Authorization', 'Bearer shiprocket-test-token')
                && $request['pickup_postcode'] === '110001'
                && $request['delivery_postcode'] === '400001'
                && (string) $request['cod'] === '1';
        });
        Http::assertSentCount(2);
    }
}