<?php

namespace App\Services\Shiprocket;

use App\Models\Order;
use App\Models\Shipment;
use App\Models\Shipping;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class ShiprocketClient
{
    public function availableCouriers(Shipping $address, array $parcel, string $paymentMethod): array
    {
        $pickupPostcode = config('services.shiprocket.pickup_postcode');

        if (!$pickupPostcode) {
            throw new RuntimeException('The Shiprocket pickup postal code is not configured.');
        }

        // Log::info('check courier service availability', ['endpoint' => 'courier/serviceability/']);

        $response = $this->request('GET', 'courier/serviceability/', [
            'pickup_postcode' => $pickupPostcode,
            'delivery_postcode' => $address->zip,
            'weight' => $parcel['weight'],
            'cod' => $paymentMethod === 'cod' ? 1 : 0,
        ]);

        Log::info('Shiprocket courier lookup response', [$response]);
        $couriers = data_get($response, 'data.available_courier_companies', []);

        return collect($couriers)->map(function (array $courier) {
            return [
                'id' => (string) data_get($courier, 'courier_company_id'),
                'name' => data_get($courier, 'courier_name'),
                'rate' => (float) data_get($courier, 'rate', data_get($courier, 'freight_charge', 0)),
                'estimated_delivery' => data_get($courier, 'estimated_delivery_days', data_get($courier, 'etd')),
            ];
        })->filter(function (array $courier) {
            return $courier['id'] !== '' && $courier['name'] !== null;
        })->values()->all();
    }

    public function createOrder(Order $order, Shipment $shipment): array
    {
        $order->loadMissing(['user', 'orderItems', 'shipping', 'payment']);
        $address = $order->shipping;

        if (!$address) {
            throw new RuntimeException('This order does not have a shipping address.');
        }

        [$firstName, $lastName] = array_pad(preg_split('/\s+/', trim($address->name), 2), 2, '');
        $paymentMethod = strtolower((string) optional($order->payment)->payment_method) === 'cod' ? 'COD' : 'Prepaid';
        $items = $order->orderItems->map(function ($item) {
            return [
                'name' => $item->title,
                'sku' => 'MJ-' . ($item->product_id ?: $item->id),
                'units' => (int) $item->quantity,
                'selling_price' => (float) $item->price,
            ];
        })->values()->all();

        if (!$items) {
            throw new RuntimeException('This order has no shippable items.');
        }

        return $this->request('POST', 'orders/create/adhoc', [
            'order_id' => 'MJ-' . $order->id,
            'order_date' => $order->created_at->format('Y-m-d H:i'),
            'pickup_location' => config('services.shiprocket.pickup_location'),
            'billing_customer_name' => $firstName,
            'billing_last_name' => $lastName,
            'billing_address' => trim($address->house_no . ' ' . $address->address),
            'billing_address_2' => '',
            'billing_city' => $address->city,
            'billing_pincode' => $address->zip,
            'billing_state' => $address->state,
            'billing_country' => $address->country ?: 'India',
            'billing_email' => $address->email ?: $order->user->email,
            'billing_phone' => $address->phone,
            'shipping_is_billing' => true,
            'order_items' => $items,
            'payment_method' => $paymentMethod,
            'shipping_charges' => (float) $order->deliver_charge,
            'giftwrap_charges' => 0,
            'transaction_charges' => (float) $order->gatway_charge,
            'total_discount' => (float) $order->discount + (float) $order->coupon,
            'sub_total' => (float) $order->subtotal,
            'length' => (float) $shipment->length,
            'breadth' => (float) $shipment->breadth,
            'height' => (float) $shipment->height,
            'weight' => (float) $shipment->weight,
        ]);
    }

    public function assignAwb(string $shipmentId, string $courierId): array
    {
        return $this->request('POST', 'courier/assign/awb', [
            'shipment_id' => $shipmentId,
            'courier_id' => $courierId,
        ]);
    }

    private function request(string $method, string $path, array $data = [], bool $retryUnauthorized = true): array
    {
        $url = rtrim((string) config('services.shiprocket.base_url'), '/') . '/' . ltrim($path, '/');
        $response = $this->authenticatedRequest($method, $url, $data);

        if ($response->status() === 401 && $retryUnauthorized) {
            Cache::forget($this->tokenCacheKey());
            $response = $this->authenticatedRequest($method, $url, $data);
        }

        $response->throw();

        return $response->json() ?? [];
    }

    private function authenticatedRequest(string $method, string $url, array $data)
    {
        $request = Http::acceptJson()->withToken($this->token())->timeout(30);

        return strtoupper($method) === 'GET'
            ? $request->get($url, $data)
            : $request->post($url, $data);
    }

    private function token(): string
    {
        $email = config('services.shiprocket.email');
        $password = config('services.shiprocket.password');

        if (!$email || !$password) {
            throw new RuntimeException('Shiprocket credentials are not configured.');
        }

        $cacheKey = $this->tokenCacheKey();
        $token = Cache::get($cacheKey);
        if ($token) {
            return $token;
        }

        $url = rtrim((string) config('services.shiprocket.base_url'), '/') . '/auth/login';
        $response = Http::acceptJson()->timeout(30)->post($url, [
            'email' => $email,
            'password' => $password,
        ]);
        $response->throw();

        $token = data_get($response->json(), 'token');
        if (!is_string($token) || $token === '') {
            throw new RuntimeException('Shiprocket authentication did not return an API token.');
        }

        $expiresIn = max(60, (int) data_get($response->json(), 'expires_in', 3600) - 120);
        Cache::put($cacheKey, $token, now()->addSeconds($expiresIn));

        return $token;
    }

    private function tokenCacheKey(): string
    {
        return 'shiprocket.token.' . sha1((string) config('services.shiprocket.email'));
    }
}
